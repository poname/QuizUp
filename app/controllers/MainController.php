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

class MainController extends ControllerBase
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
       /* $list = array();
        foreach ($countries as $country) {
            //$name = $country->getName();
            array_push($list, $this->translator->_($country->getName())) ;
            $country.$name = "!!";
        }
        */
        $this->view->setVar('countries', $countries);

        Tag::appendTitle($this->translator->_("SIGNUP_AN_ACCOUNT"));
    }

    public function successAction(){
    }

}