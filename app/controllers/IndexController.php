<?php
/**
 * Created by IntelliJ IDEA.
 * User: mohammad
 * Date: 8/1/15
 * Time: 1:05 AM
 */

namespace QUIZUP\Controllers;

class IndexController extends ControllerBase {
    public function initialize(){
        parent::initialize();
    }
    public function indexAction(){
        return $this->response->redirect('main/');
    }
}