<?php
/**
 * Created by IntelliJ IDEA.
 * User: HatsOn
 * Date: 11/11/2015
 * Time: 1:05 AM
 */

namespace QUIZUP\Plugins;


use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;

class ACL extends Plugin
{
    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $auth = $this->session->get('auth-identity');
        $controller = $dispatcher->getControllerClass();

        if(!$auth && class_exists($controller) && $controller::isPrivate() == true){
            $dispatcher->forward(array(
                'namespace' => 'QUIZUP\Controllers\Login',
                'controller' => 'index',
                'action'     => 'index'
            ));
            $this->session->destroy();
            return false;
        }
    }

}