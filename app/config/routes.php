<?php
/**
 * Created by IntelliJ IDEA.
 * User: mohammad
 * Date: 6/12/15
 * Time: 11:31 AM
 */

$router = new Phalcon\Mvc\Router();
$router->removeExtraSlashes(true);

/** We can add extra and exceptional routes like this in below */
//$router->add('/login', array(
//    'namespace' => 'QUIZUP\Controllers\Login',
//    'controller' => 'index',
//    'action' => 'index'
//));
//$router->add('/login/', array(
//    'namespace' => 'QUIZUP\Controllers\Login',
//    'controller' => 'index',
//    'action' => 'index'
//));
//$router->add('/login/:controller', array(
//    'namespace' => 'QUIZUP\Controllers\Login',
//    'controller' => 1,
//    'action' => 'index'
//));
//$router->add('/login/:controller/:action', array(
//    'namespace' => 'QUIZUP\Controllers\Login',
//    'controller' => 1,
//    'action' => 2,
//));
//$router->add('/login/:controller/:action/:params', array(
//    'namespace' => 'QUIZUP\Controllers\Login',
//    'controller' => 1,
//    'action' => 2,
//    'params' => 3
//));
//
//$router->add('/signup', array(
//    'namespace' => 'QUIZUP\Controllers\Signup',
//    'controller' => 'index',
//    'action' => 'index'
//));
//$router->add('/signup/', array(
//    'namespace' => 'QUIZUP\Controllers\Signup',
//    'controller' => 'index',
//    'action' => 'index'
//));
//$router->add('/signup/:controller', array(
//    'namespace' => 'QUIZUP\Controllers\Signup',
//    'controller' => 1,
//    'action' => 'index'
//));
//$router->add('/signup/:controller/:action', array(
//    'namespace' => 'QUIZUP\Controllers\Signup',
//    'controller' => 1,
//    'action' => 2,
//));
//$router->add('/signup/:controller/:action/:params', array(
//    'namespace' => 'QUIZUP\Controllers\Signup',
//    'controller' => 1,
//    'action' => 2,
//    'params' => 3
//));

$router->setDefaultNamespace('QUIZUP\Controllers');


return $router;