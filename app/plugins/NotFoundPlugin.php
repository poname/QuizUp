<?php
/**
 * Created by IntelliJ IDEA.
 * User: dani
 * Date: 3/25/2016
 * Time: 7:19 AM
 */

namespace QUIZUP\Plugins;

use Phalcon\Mvc\User\Plugin;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

class NotFoundPlugin extends Plugin{
    public function beforeException(Event $event, Dispatcher $dispatcher, $exception)
    {
        // Handle 404 exceptions
        if ($exception instanceof DispatchException) {
            $dispatcher->forward(array(
                'controller' => 'index',
                'action'     => 'show404'
            ));
            return false;
        }

        // Handle other exceptions
        $this->logger->error(var_export($exception->__toString(), true));
        
        $dispatcher->forward(array(
            'controller' => 'index',
            'action'     => 'show503'
        ));

        return false;
    }
}