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
use QUIZUP\Models\User;

class LoginController extends ControllerBase
{

    public function initialize()
    {
    	//echo 'hi';
        parent::initialize();
    }

    public function indexAction(){
    	echo 'hi';
    	if ($this->session->has("login")) {
    		return $this->response->redirect('login/success');
    	}
    }

    public function successAction(){
    	echo 'by';
    	if(!$this->session->has("login")){
    		$this->flashSession->error($this->translator->_('INVALID_REQUEST') . $this->session->get("login"));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'login',
                    'action' => 'index'
                )
            );
    	}
    }

    public function doAction(){
    	$email = $this->request->getPost('email'); //phalcon email sanitizing
        //$password = $this->security->hash($this->request->getPost('password'));
        $password = $this->request->getPost('password');

    	//$user = User::find("email = '$email' AND password = '$password'");
        $user = User::findByEmail($email);
    	//$user = User::findFirst("email = '$email' AND password = '$password'") or die($this->translator->_('INVALID_REQUEST'));
    	//echo isset($user);
    	//echo count($user);
    	if(!count($user) or !$this->security->checkHash($password, $user->getPassword())){
    		$this->flashSession->error($this->translator->_('USER_OR_PASSWORD_INVALID'));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'login',
                    'action' => 'index'
                )
            );
    	}

    	if(!$user[0]->getIsActive()){
    		$this->flashSession->error($this->translator->_('EMAIL_NOT_CONFIRMED'));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'login',
                    'action' => 'index'
                )
            );
    	}

    	// Set a session variable
        $this->session->set("login", "true");

    	return $this->response->redirect('login/success');
    }

    public function logoutAction(){
        $this->session->remove("login");

        $this->flashSession->warning($this->translator->_('LOGOUT_COMPLETED'));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'login',
                    'action' => 'index'
                )
            );
        // $this->session->destroy();
    }

}