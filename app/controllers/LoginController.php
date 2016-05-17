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
use QUIZUP\Models\Quiz;
use QUIZUP\Models\User;
use Phalcon\Events\Manager as EventsManager;
//use QUIZUP\Plugins\;
use Phalcon\Events\EventsAwareInterface;
use QUIZUP\Plugins\AchievementListener;

class LoginController extends ControllerBase implements EventsAwareInterface
{
    protected $_eventsManager;

    public function initialize()
    {
    	//echo 'hi';
        parent::initialize();
        $this->_eventsManager = new EventsManager();
        // Attach the listener to the EventsManager
        $this->_eventsManager->attach('login-success', new AchievementListener());
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
        $this->view->setVar('score', $this->session->get('user')->getPoints());
		$users_ranked = User::find(
            array(
                "order" => "points DESC",
                "limit" => 3
            )
        ) or array();
		  $this->view->setVar('rankings', $users_ranked);
        //echo 'err';
        //echo count($users_ranked);

        //some achievements by listener :)
        $ach = $this->_eventsManager->fire("login-success:afterSuccessAction", $this);
        $this->view->setVar('achievements', $ach);

        /////////////////////////////////////////////////////////////
        ////////some other achievements by manual handling///////////
        /////////////////////////////////////////////////////////////
        $achives = array();
        $uid =  $this->session->get('auth')['id'];

        //cooperate in 10 quizes or more
        $userQuizes =  Quiz::find("user1_id = '$uid' OR user2_id = '$uid'") or array();
        if(count($userQuizes) >= 10)
            array_push($achives, 'tenQuiz');

        //iranian user
        $user = User::find("user_id = '$uid'");
        $cid = $user[0]->getCid() ;
        $country = Country::find("cid = '$cid'");
        if(strcasecmp($country[0]->getName(), 'iran') == 0)
            array_push($achives, 'iranian');

        //first, second or third user in ranking
        if(count($users_ranked)>0 && $users_ranked[0]->getUserId()==$uid)
            array_push($achives, 'first');
        else if(count($users_ranked)>1 && $users_ranked[1]->getUserId()==$uid)
            array_push($achives, 'second');
        else if(count($users_ranked)>2 && $users_ranked[2]->getUserId()==$uid)
            array_push($achives, 'third');



        $this->view->setVar('achives', $achives);
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

        $this->session->set('user', $user[0]);

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