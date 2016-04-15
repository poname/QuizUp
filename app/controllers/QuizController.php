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
use QUIZUP\Libraries\Exceptions\Exception;
use QUIZUP\Libraries\Exceptions\InvalidRequestException;
use QUIZUP\Models\Question;
use QUIZUP\Models\QuestionCategory;
use QUIZUP\Models\Quiz;
use QUIZUP\Models\Custom\Quiz as CustomQuiz;
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
            //getting the input
            $category_id = $this->request->getPost('category', 'int') or die('invalid request');

                //select a random user ; @TODO ORDER BY RAND() is slow , a better way would be better :)
            $user = $this->session->get('auth');
            $phql = "SELECT user_id FROM QUIZUP\Models\User " .
                "WHERE user_id != {$user['id']} " .
                'ORDER BY RAND() LIMIT 1';
            $ret  = $this->modelsManager->executeQuery($phql);

            $competitor = null; //competitor user id
            foreach($ret as $r){
                $competitor = $r->user_id;
                break;
            }

            //select 5 random questions  @TODO ORDER BY RAND() is slow , a better way would be better :)
            $phql = "SELECT q.qid FROM QUIZUP\Models\Question q " .
                "WHERE q.cid = $category_id " .
                'ORDER BY RAND() LIMIT 5';
            $ret  = $this->modelsManager->executeQuery($phql);
            $question_ids = array(); //competitor user id
            foreach($ret as $r){
                $question_ids[] = $r->qid;
            }

            // validation
            if(count($question_ids)<5){
                $this->flashSession->error($this->translator->_('SELECTED_CATEGORY_HAS_NOT_ENOUGH_QUESTIONS_SELECT_DIFFERENT_ONE'));
                return $this->_redirectBack();
            }
            if(!$competitor){
                $this->flashSession->error($this->translator->_('NO_USER_IS_AVAILABLE_RIGHT_NOW'));
                return $this->_redirectBack();
            }
            $competitor = User::findFirst('user_id = ' . $competitor);
            if(!$competitor){
                $this->flashSession->error($this->translator->_('NO_USER_IS_AVAILABLE_RIGHT_NOW'));
                return $this->_redirectBack();
            }

            $category = QuestionCategory::findFirst('cid = ' . $category_id);
            if(!$competitor){
                $this->flashSession->error($this->translator->_('INTERNAL_ERROR'));
                return $this->_redirectBack();
            }

            // generate quiz instance
            $quiz = new Quiz();
            $quiz
                ->setCid($category_id)
                ->setQuestion1($question_ids[0])
                ->setQuestion2($question_ids[1])
                ->setQuestion3($question_ids[2])
                ->setQuestion4($question_ids[3])
                ->setQuestion5($question_ids[4])
                ->setUser1Id($user['id'])
                ->setUser1State(new Db\RawValue('default'))
                ->setUser2Id($competitor->getUserId())
                ->setUser2State(new Db\RawValue('default'))
                ->setUser1StepLastUpdate(new Db\RawValue('default'))
                ->setUser2StepLastUpdate(new Db\RawValue('default'));

            if (!$quiz->save()) {
                $this->logger->error(var_export($quiz->getMessages(),true));
                $this->flashSession->error($this->translator->_('INTERNAL_ERROR'));
                return $this->_redirectBack();
            }

            //send email to other opponent
            $quiz_link = $this->config->application->webpageURL . "quiz/do/{$quiz->getQid()}";
            $mail = new \PHPMailer();
            // Set PHPMailer to use the sendmail transport
            $mail->isSendmail();
            $mail->setFrom('noreplay@ccweb.ir', 'QuizUP');
            $mail->addAddress($competitor->getEmail(), "{$competitor->getName()} {$competitor->getFamily()}");
            $mail->Subject = 'Quiz Invitation';
            $mail->msgHTML($this->view->getRender('emails','quiz-invitation',array(
                'full_name'=>$competitor->getName(),
                'asker_name' => $user['name'],
                'category_name' => $category->getName(),
                'link'=> $quiz_link
            )));
            $mail->AltBody = $quiz_link;
//            if (!$mail->send()) {
//                $quiz->delete();
//                $this->logger->error('could not send email to opponent: '.$mail->ErrorInfo);
//                $this->flashSession->error($this->translator->_('INTERNAL_ERROR'));
//                return $this->_redirectBack();
//            }

            // all set ! let's start the quiz , shall we? :)
            return $this->response->redirect('quiz/do/' . $quiz->getQid());

        }else{
            $categories = QuestionCategory::find();
            $this->view->setVar('categories', $categories);
        }
    }
    public function doAction($qid){
        $qid = $this->filter->sanitize($qid, 'int');
        if(!$qid) throw new InvalidRequestException('invalid quiz id');
        
        $user = $this->session->get('auth');
        $quiz = CustomQuiz::findFirst('qid = ' . $qid);
        if(!$quiz) throw new InvalidRequestException('invalid quiz instance');

        $quiz->setSideUser($user['id']);
        $status = $quiz->getStatus();


        $current_question = null;
        if($status['step']!= 0 && $status['step']!=6){
            $property = "Question{$status['step']}";
            $current_question = $quiz->$property;
        }
        $this->view->setVar('quiz_id', $qid);
        $this->view->setVar('current_question', $current_question);
        $this->view->setVars($quiz->getStatus(),true);
    }

    public function answerAction()
    {
        $this->request->isPost() or die('invalid request');

        $quiz_id = $this->request->getPost('quiz_id', 'int');
        $step = $this->request->getPost('step', 'int');
        $answer = $this->request->getPost('answer', 'int');
        
        //validation
        if (!$quiz_id || !is_numeric($quiz_id)) {
            $this->logger->error('invalid quiz_id passed to /quiz/answer ' . $quiz_id);
            return $this->jsonResponse(false, array('message' => $this->translator->_('INVALID_REQUEST')));
        }
        $quiz = CustomQuiz::findFirst('qid=' . $quiz_id);
        if(!$quiz){
            $this->logger->error('quiz model not found in  /quiz/answer ' . $quiz_id);
            return $this->jsonResponse(false, array('message' => $this->translator->_('INVALID_REQUEST')));
        }
        
        if(!is_numeric($step) || ((int)$step)<0 || ((int)$step)>6 ){
            $this->logger->error('invalid step passed to /quiz/answer ' . $step);
            return $this->jsonResponse(false, array('message' => $this->translator->_('INVALID_REQUEST')));
        }
        
        if(!$answer || !is_numeric($answer) || ((int)$answer)<0 || ((int)$answer)>6 ){
            $this->logger->error('invalid answer passed to /quiz/answer ' . $answer);
            return $this->jsonResponse(false, array('message' => $this->translator->_('INVALID_REQUEST')));
        }
        
        $user = $this->session->get('auth');
        $quiz->setSideUser($user['id']);
        $ret = null;
        try {
            $ret = $quiz->handleAnswer($answer);
        }catch (Exception $e){
            $ret = array(false, 'INTERNAL_ERROR');
        }
        
        if($quiz->isFinished()){
            return $this->jsonResponse(true);
        }

        $new_question = $quiz->getCurrentQuestion();
        if ($new_question) {
            $new_question = $new_question->toArray();
            unset($new_question['correct']);
        }

        return $this->jsonResponse($ret[0], array(
            'message'=> $ret[0] == false ? $ret[1] : '',
            'new_question' => $new_question
        ));

        // we should first desing the ui so we can program for here
    }

}
