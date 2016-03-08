<?php
/**
 * Created by IntelliJ IDEA.
 * User: root
 * Date: 3/7/16
 * Time: 1:53 AM
 */

namespace QUIZUP\Controllers;


use Phalcon\Db;
use Phalcon\Tag;
use QUIZUP\Models\Country;
use QUIZUP\Models\User;

class SignupController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction(){
        if ($this->session->has("login")) {
            return $this->response->redirect('login/success');
        }
        
        $countries = Country::find() or array();
        $this->view->setVar('countries', $countries);
        Tag::appendTitle($this->translator->_("SIGNUP_AN_ACCOUNT"));
    }

    public function successAction(){
    }

    public function confirmAction(){
        $user_id = $this->request->getQuery('uid','int');
        $code = $this->request->getQuery('code', 'alphanum');
        $user = User::findFirst("user_id = $user_id") or die($this->translator->_('INVALID_REQUEST'));
        if ($user->getVerificationCode() != $code) {
            die($this->translator->_('INVALID_REQUEST'));
        }
        $user->setIsActive(1);
        if(!$user->save()){
            $this->logger->error(var_export($user->getMessages(), true));
            die($this->translator->_('INTERNAL_ERROR'));
        }
        $this->flashSession->success($this->translator->_('SUCCESSFULLY_ACTIVATED'));
        return $this->dispatcher->forward(
            array(
                'controller' => 'login',
                'action' => 'index'
            )
        );
    }

    public function doAction(){
        $name = $this->request->getPost('name');
        $family = $this->request->getPost('family');
        $email = $this->request->getPost('email','email'); //phalcon email sanitizing
        $password = $this->request->getPost('password');
        $password_repeat = $this->request->getPost('password_repeat');
        $gender = $this->request->getPost('gender');
        $cid = $this->request->getPost('cid');

        if($password !== $password_repeat){
            $this->flashSession->error($this->translator->_('PASSWORD_AND_REPEAT_SHOULD_MATCH'));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'signup',
                    'action' => 'index'
                )
            );
        }

        $verification_code = md5("QU1zUP" . time());

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->security->hash($password));
        $user->setName($name);
        $user->setFamily($family);
        $user->setCid($cid);
        $user->setGender($gender);
        $user->setIsActive(new Db\RawValue('default'));
        $user->setVerificationCode($verification_code);

        if(!$user->save()){
            $this->logger->error(var_export($user->getMessages(),true));
            $this->flashSession->error($this->translator->_('INTERNAL_ERROR'));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'signup',
                    'action' => 'index'
                )
            );
        }

        $verfication_link = $this->config->application->webpageURL . "signup/confirm?uid={$user->getUserId()}&code={$user->getVerificationCode()}";
        $mail = new \PHPMailer();
        // Set PHPMailer to use the sendmail transport
        $mail->isSendmail();
        $mail->setFrom('noreplay@ccweb.ir', 'QuizUP');
        $mail->addAddress($email, "$name $family");
        $mail->Subject = 'Confirmation link';
        $mail->msgHTML($this->view->getRender('emails','signup-success',array(
            'full_name'=>"$name",
            'link'=> $verfication_link
        )));
        $mail->AltBody = $verfication_link;

        if (!$mail->send()) {
            $user->delete();
            $this->flashSession->error($this->translator->_('WE_COULDNT_SEND_YOU_EMAIL'));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'signup',
                    'action' => 'index'
                )
            );
        }

        return $this->response->redirect('signup/success');
    }

}