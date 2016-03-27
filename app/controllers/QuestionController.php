<?php
/**
 * Created by IntelliJ IDEA.
 * User: dani
 * Date: 3/27/2016
 * Time: 9:31 AM
 */

namespace QUIZUP\Controllers;


use QUIZUP\Models\Question;
use QUIZUP\Models\QuestionCategory;

class QuestionController extends ControllerBase
{
    public function initialize()
    {
        //echo 'hi';
        parent::initialize();
    }

    public function indexAction(){

    }

    public function createAction(){

        $categories = QuestionCategory::find() or array();
        $this->view->setVar('categories', $categories);

        if($this->request->isPost()){
            $cid = $this->request->getPost('cid');
            $description = $this->request->getPost('description');
            $ans1 = $this->request->getPost('ans1');
            $ans2 = $this->request->getPost('ans2');
            $ans3 = $this->request->getPost('ans3');
            $ans4 = $this->request->getPost('ans4');
            $correct = $this->request->getPost('correct');

            $user_id = $this->session->get('auth')['id'] ;

            $question = new Question();
            $question->setCid($cid)
                ->setDescription($description)
                ->setAns1($ans1)
                ->setAns2($ans2)
                ->setAns3($ans3)
                ->setAns4($ans4)
                ->setCorrect($correct);

            if(!$question->save()){
                $this->logger->error(var_export($question->getMessages(),true));
                $this->flashSession->error($this->translator->_('INTERNAL_ERROR'));
                //$this->response->resetHeaders();
                $this->response->redirect('/question/create');
                return $this->dispatcher->forward(
                    array(
                        'controller' => 'question',
                        'action' => 'list'
                    )
                );
            }

            $this->flashSession->success($this->translator->_('QUESTION_CREATED'));
            $this->response->redirect('/question/create');
            return $this->dispatcher->forward(
                array(
                    'controller' => 'question',
                    'action' => 'list'
                )
            );
        }
        else{

        }
    }

    public function listAction()
    {
        $questions = Question::find() or array();
        $this->view->setVar('questions', $questions);
    }

    public function deleteAction(){

    }

    public function editAction(){

    }
}