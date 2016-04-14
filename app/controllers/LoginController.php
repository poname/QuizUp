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

    private function _registerSession($user)
    {
        $this->session->set(
            'auth',
            array(
                'id'   => $user->getUserId(),
                'name' => $user->getName()
            )
        );
    }

    public function indexAction(){
    	if ($this->session->has('auth')) {
    		return $this->response->redirect('login/success');
    	}
    }

    public function successAction(){
    	//echo 'by';
    	if(!$this->session->has('auth')){
    		$this->flashSession->error($this->translator->_('INVALID_REQUEST') . $this->session->get('auth'));
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
        $password = $this->request->getPost('password');

    	$user = User::find("email = '$email' AND password = '$password'");
    	//$user = User::findFirst("email = '$email' AND password = '$password'") or die($this->translator->_('INVALID_REQUEST'));
    	//echo isset($user);
    	//echo count($user);
    	if(!count($user)){
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

        $this->_registerSession($user[0]);

    	// Set a session variable
        //$this->session->set("login", "true");
        //$this->session->set("user_id", $user[0]->getUserId());
        if($this->session->has('nextPage'))
            return $this->response->redirect($this->session->get('nextPage'));
        else
    	    return $this->response->redirect('login/success');
    }

    public function logoutAction(){
        //$this->session->remove("login");
        $this->session->remove('auth');
        $this->session->destroy();

        $this->flashSession->success($this->translator->_('LOGOUT_COMPLETED'));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'login',
                    'action' => 'index'
                )
            );
        // $this->session->destroy();
    }

}