<?php
/**
 * Created by IntelliJ IDEA.
 * User: root
 * Date: 3/7/16
 * Time: 1:53 AM
 */

namespace QUIZUP\Controllers;


use Phalcon\Tag;
use QUIZUP\Models\User;

class SignupController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction(){
        Tag::appendTitle($this->translator->_("SIGNUP_AN_ACCOUNT"));
    }

    public function doAction(){
        $email = $this->request->getPost('email','email'); //phalcon email sanitizing
        $password = $this->request->getPost('password');
        $password_repeat = $this->request->getPost('password_repeat');

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->security->hash($password));

        if($password !== $password_repeat){
            $this->flashSession->error($this->translator->_('PASSWORD_AND_REPEAT_SHOULD_MATCH'));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'signup',
                    'action' => 'index'
                )
            );
        }
        if(!$user->save()){
            $this->flashSession->error($this->translator->_('INTERNAL_ERROR'));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'signup',
                    'action' => 'index'
                )
            );
        }
        return $this->response->redirect('user/');
    }

}