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

    }

   public function createAction(){
       if($this->request->isPost()){
           $name = $this->request->getPost('name');
           //$cid = md5("QU1zUP" . time(). rand());
           $user_id = $this->session->get('auth')['id'] ;
           //$this->request->
            
           if(count(QuestionCategory::find("name='" . $name . "'"))){
               //$this->logger->error(var_export($category->getMessages(),true));
               $this->flashSession->error($name . '<br>' . $this->translator->_('REPEATED_CATEGORY'));
               $this->response->redirect('/category/create');
               return;
           }


           $category = new QuestionCategory();
           $category->setName($name);
           //$category->setCid($cid);
           $category->setUserId($user_id);

           if(!$category->save()){
               $this->logger->error(var_export($category->getMessages(),true));
               $this->flashSession->error($this->translator->_('INTERNAL_ERROR'));
               //$this->flashSession->error($name . '<br>' . $this->translator->_('REPEATED_CATEGORY'));
               $this->response->redirect('/category/create');
               return;
           }
           $this->flashSession->success($name . "<br>" . $this->translator->_('CATEGORY_CREATED'));
           $this->response->redirect('/category/create');
           return;
       }
   }

       }
   }

    public function listAction(){
        Tag::appendTitle($this->translator->_('CATEGORIES'));
        $categories = QuestionCategory::find() or array();
        $this->view->setVar('categories', $categories);
    }

    public function deleteAction(){
        //$this->indexAction();
        if($this->request->isPost()) {
            //$id = $this->request->getQuery("id");
            $id = $this->request->getPost("cid");
            $cat = QuestionCategory::find("cid='" . $id . "'");
            $name = $cat[0]->getName();

            if (!$cat[0]->delete()) {

            }

            $this->flashSession->success($name . '<br>' . $this->translator->_('DELETED_SUCCESSFULLY'));
            /*
            return $this->dispatcher->forward(
                array(
                    'controller' => 'category',
                    'action' => 'list'
                )
            );
            */
        }
    }

    public function editAction(){
        //$this->indexAction();
        if($this->request->isPost()){
            $cid = $this->request->getPost("cid");
            $newName = $this->request->getPost('newName');

            $cat = QuestionCategory::find("cid='" . $cid . "'");
            $cat[0]->setName($newName);

            if(!$cat[0]->save()){

            }

            $this->flashSession->success($newName .  '<br>' . $this->translator->_('EDITED_SUCCESSFULLY'));
            /*
            return $this->dispatcher->forward(
                array(
                    'controller' => 'category',
                    'action' => 'list'
                )
            );
            */
        }
        /*
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
        */

    }

}
