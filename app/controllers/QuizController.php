<?php
/**
 * Created by IntelliJ IDEA.
 * User: dani
 * Date: 3/14/2016
 * Time: 11:25 AM
 */

namespace QUIZUP\Controllers;


use Phalcon\Db;
use Phalcon\Tag;
use QUIZUP\Models\Question;
use QUIZUP\Models\QuestionCategory;
use QUIZUP\Models\User;

class QuizController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction(){
        //view for pick selected category
    }

    public function selectCategoryAction(){
        if($this->request->isPost()){
            die();
        }else{
            $categories = QuestionCategory::find();
            $this->view->setVar('categories', $categories);
        }
    }
    public function startAction($cid){
    }
}
