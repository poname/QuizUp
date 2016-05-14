<?php
/**
 * Created by IntelliJ IDEA.
 * User: mohammad
 * Date: 8/1/15
 * Time: 1:05 AM
 */

namespace QUIZUP\Controllers;

use Phalcon\Db;
use Phalcon\Tag;
use QUIZUP\Models\Question;
use QUIZUP\Models\Quiz;

class ApiController extends ControllerBase {
    public function initialize(){
        parent::initialize();
    }
    public function indexAction(){
        echo 'ji';
    }

    public function generateNewQuizAction(){
        //echo 'hi';

        $uid1 = $this->request->getQuery("uid1");
        $uid2 = $this->request->getQuery("uid2");
        $category_id  = $this->request->getQuery("cat");

        //select 5 random questions
        //$phql = "SELECT q.qid FROM QUIZUP\Models\Question q " .
        //    "WHERE q.cid = $category_id " .
        //    'ORDER BY RAND() LIMIT 5';
        //$ret  = $this->modelsManager->executeQuery($phql);

        $ret = Question::find(
            // category_id constraints is not affected yet !!
            array(
                "cid" => $category_id,
                "order" => "RAND()",
                "limit" => 5
            )
        ) or array();


        $question_ids = array(); //competitor user id
        foreach($ret as $r){
            $question_ids[] = $r->qid;
        }


        // generate quiz instance
        $time = date('Y-m-d H:i:s');
        $quiz = new Quiz();
        $quiz
            ->setCid($category_id)
            ->setQuestion1($question_ids[0])
            ->setQuestion2($question_ids[1])
            ->setQuestion3($question_ids[2])
            ->setQuestion4($question_ids[3])
            ->setQuestion5($question_ids[4])
            ->setUser1Id($uid1)
            ->setUser2Id($uid2)
            ->setUser1State(new Db\RawValue('default'))
            ->setUser2State(new Db\RawValue('default'))
            ->setUser1StepLastUpdate($time)
            ->setUser2StepLastUpdate($time)
            ->setUser1EarnedPoints(new Db\RawValue('default'))
            ->setUser2EarnedPoints(new Db\RawValue('default'))
            ->setUser1CorrectAnswersCount(new Db\RawValue('default'))
            ->setUser2CorrectAnswersCount(new Db\RawValue('default'));



        if (!$quiz->save()) {
            $this->logger->error(var_export($quiz->getMessages(),true));
        }

        $qid = $quiz->getQid();

        $questions = array();

        foreach($ret as $soal){
            $temp = array(
                'body' => $soal->getDescription(),
                'choices' => array(
                    1 => $soal->getAns1(),
                    2 => $soal->getAns2(),
                    3 => $soal->getAns3(),
                    4 => $soal->getAns4(),
                ),
                'correct' => $soal->getCorrect()
            );
            array_push($questions, $temp);
        }

        return $this->jsonResponse(
            true,
            array(
                'quizId' => $qid,
                'questions' => $questions
            )
        );

    }

    public function saveResultAction(){

    }
}