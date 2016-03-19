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

class CategoryController extends ControllerBase
{

    public function initialize()
    {
        //echo 'hi';
        parent::initialize();
    }

    public function indexAction(){

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

    public function listAction(){
        Tag::appendTitle($this->translator->_('CATEGORIES'));
        $categories = QuestionCategory::find() or array();
        $this->view->setVar('categories', $categories);
    }

    public function deleteAction(){
        //$this->indexAction();

        $id = $this->request->getQuery("id");
        $cat = QuestionCategory::find("cid='" . $id . "'");
        $name = $cat[0]->getName();

        if(!$cat[0]->delete()){

        }

        $this->flashSession->success($name .  '<br>' . $this->translator->_('DELETED_SUCCESSFULLY'));
        return $this->dispatcher->forward(
            array(
                'controller' => 'category',
                'action' => 'list'
            )
        );
    }

    public function editAction(){
        //$this->indexAction();
        $operation = $this->request->getQuery("op");
        $id = $this->request->getQuery("id");
        $cat = QuestionCategory::find("cid='" . $id . "'");

        if($operation == 'change'){
            $newName = $this->request->getQuery('newName');
            $cat[0]->setName($newName);

            if(!$cat[0]->save()){
                echo 'ride';
            }

            $this->flashSession->success($newName .  '<br>' . $this->translator->_('EDITED_SUCCESSFULLY'));
            return $this->dispatcher->forward(
                array(
                    'controller' => 'category',
                    'action' => 'list'
                )
            );
        }
        else{
            $name = $cat[0]->getName();

            $this->view->setVar('catName', $name);
            $this->view->setVar('catId', $id);
        }

    }

    protected function changeAction(){
        echo 'hi';
        $newName = $this->request->getPost('newName');

        $id = $this->request->getPost("id");

        $cat = QuestionCategory::find("cid='" . $id . "'");
        $cat[0]->setName($newName);

        if(!$cat[0]->save()){
            echo 'ride';
        }

        $this->flashSession->success($newName .  '<br>' . $this->translator->_('EDITED_SUCCESSFULLY'));
        return $this->dispatcher->forward(
            array(
                'controller' => 'category',
                'action' => 'list'
            )
        );

    }

}