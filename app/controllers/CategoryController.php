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
use QUIZUP\Models\QuestionCategory;
use QUIZUP\Models\User;

class CategoryController extends ControllerBase
{

    public function initialize()
    {
        //echo 'hi';
        parent::initialize();
    }

    public function indexAction(){
        echo 'hi';
        if (!$this->session->has("login")){
            $this->flashSession->error($this->translator->_('LOGIN_FIRST'));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'login',
                    'action' => 'index'
                )
            );
        }
    }

    public function addAction(){
        $this->indexAction();
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

   public function createAction(){
       $name = $this->request->getPost('name');
       $cid = md5("QU1zUP" . time(). rand());
       $user_id = $this->session->get(user_id) ;

       if(count(QuestionCategory::find("name='" . $name . "'"))){
           //$this->logger->error(var_export($category->getMessages(),true));
           $this->flashSession->error($name . '<br>' . $this->translator->_('REPEATED_CATEGORY'));
           return $this->dispatcher->forward(
               array(
                   'controller' => 'category',
                   'action' => 'add'
               )
           );
       }

       $category = new QuestionCategory();
       $category->setName($name);
       $category->setCid($cid);
       $category->setUserId($user_id);

       if(!$category->save()){
           $this->logger->error(var_export($category->getMessages(),true));
           $this->flashSession->error($this->translator->_('INTERNAL_ERROR'));
           return $this->dispatcher->forward(
               array(
                   'controller' => 'category',
                   'action' => 'add'
               )
           );
       }
       $this->flashSession->success($name . "<br>" . $this->translator->_('CATEGORY_CREATED'));
       return $this->dispatcher->forward(
           array(
               'controller' => 'category',
               'action' => 'add'
           )
       );
   }
    public function logoutAction(){
        $this->session->remove("login");

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