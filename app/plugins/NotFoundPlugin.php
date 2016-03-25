<?php
/**
 * Created by IntelliJ IDEA.
 * User: dani
 * Date: 3/25/2016
 * Time: 7:19 AM
 */

namespace QUIZUP\Plugins;

use Phalcon\Mvc\User\Plugin;

class NotFoundPlugin extends Plugin{
    public function beforeException(){
        $this->flash->error("Not Found Exception");
        $this->dispatcher->forward(
            array(
                'controller' => 'error',
                'action'     => 'index'
            )
        );
    }
}