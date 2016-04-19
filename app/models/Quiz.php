<?php

namespace QUIZUP\Models;

class Quiz extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $qid;

    /**
     *
     * @var integer
     */
    protected $cid;

    /**
     *
     * @var integer
     */
    protected $question1;

    /**
     *
     * @var integer
     */
    protected $question2;

    /**
     *
     * @var integer
     */
    protected $question3;

    /**
     *
     * @var integer
     */
    protected $question4;

    /**
     *
     * @var integer
     */
    protected $question5;

    /**
     *
     * @var integer
     */
    protected $user1_id;

    /**
     *
     * @var integer
     */
    protected $user2_id;

    /**
     *
     * @var string
     */
    protected $user1_state;

    /**
     *
     * @var string
     */
    protected $user2_state;

    /**
     *
     * @var integer
     */
    protected $user1_correct_answers_count;

    /**
     *
     * @var integer
     */
    protected $user2_correct_answers_count;

    /**
     *
     * @var integer
     */
    protected $user1_earned_points;

    /**
     *
     * @var integer
     */
    protected $user2_earned_points;

    /**
     *
     * @var string
     */
    protected $user1_step_last_update;

    /**
     *
     * @var string
     */
    protected $user2_step_last_update;

    /**
     * Method to set the value of field qid
     *
     * @param integer $qid
     * @return $this
     */
    public function setQid($qid)
    {
        $this->qid = $qid;

        return $this;
    }

    /**
     * Method to set the value of field cid
     *
     * @param integer $cid
     * @return $this
     */
    public function setCid($cid)
    {
        $this->cid = $cid;

        return $this;
    }

    /**
     * Method to set the value of field question1
     *
     * @param integer $question1
     * @return $this
     */
    public function setQuestion1($question1)
    {
        $this->question1 = $question1;

        return $this;
    }

    /**
     * Method to set the value of field question2
     *
     * @param integer $question2
     * @return $this
     */
    public function setQuestion2($question2)
    {
        $this->question2 = $question2;

        return $this;
    }

    /**
     * Method to set the value of field question3
     *
     * @param integer $question3
     * @return $this
     */
    public function setQuestion3($question3)
    {
        $this->question3 = $question3;

        return $this;
    }

    /**
     * Method to set the value of field question4
     *
     * @param integer $question4
     * @return $this
     */
    public function setQuestion4($question4)
    {
        $this->question4 = $question4;

        return $this;
    }

    /**
     * Method to set the value of field question5
     *
     * @param integer $question5
     * @return $this
     */
    public function setQuestion5($question5)
    {
        $this->question5 = $question5;

        return $this;
    }

    /**
     * Method to set the value of field user1_id
     *
     * @param integer $user1_id
     * @return $this
     */
    public function setUser1Id($user1_id)
    {
        $this->user1_id = $user1_id;

        return $this;
    }

    /**
     * Method to set the value of field user2_id
     *
     * @param integer $user2_id
     * @return $this
     */
    public function setUser2Id($user2_id)
    {
        $this->user2_id = $user2_id;

        return $this;
    }

    /**
     * Method to set the value of field user1_state
     *
     * @param string $user1_state
     * @return $this
     */
    public function setUser1State($user1_state)
    {
        $this->user1_state = $user1_state;

        return $this;
    }

    /**
     * Method to set the value of field user2_state
     *
     * @param string $user2_state
     * @return $this
     */
    public function setUser2State($user2_state)
    {
        $this->user2_state = $user2_state;

        return $this;
    }

    /**
     * Method to set the value of field user1_correct_answers_count
     *
     * @param integer $user1_correct_answers_count
     * @return $this
     */
    public function setUser1CorrectAnswersCount($user1_correct_answers_count)
    {
        $this->user1_correct_answers_count = $user1_correct_answers_count;

        return $this;
    }

    /**
     * Method to set the value of field user2_correct_answers_count
     *
     * @param integer $user2_correct_answers_count
     * @return $this
     */
    public function setUser2CorrectAnswersCount($user2_correct_answers_count)
    {
        $this->user2_correct_answers_count = $user2_correct_answers_count;

        return $this;
    }

    /**
     * Method to set the value of field user1_earned_points
     *
     * @param integer $user1_earned_points
     * @return $this
     */
    public function setUser1EarnedPoints($user1_earned_points)
    {
        $this->user1_earned_points = $user1_earned_points;

        return $this;
    }

    /**
     * Method to set the value of field user2_earned_points
     *
     * @param integer $user2_earned_points
     * @return $this
     */
    public function setUser2EarnedPoints($user2_earned_points)
    {
        $this->user2_earned_points = $user2_earned_points;

        return $this;
    }

    /**
     * Method to set the value of field user1_step_last_update
     *
     * @param string $user1_step_last_update
     * @return $this
     */
    public function setUser1StepLastUpdate($user1_step_last_update)
    {
        $this->user1_step_last_update = $user1_step_last_update;

        return $this;
    }

    /**
     * Method to set the value of field user2_step_last_update
     *
     * @param string $user2_step_last_update
     * @return $this
     */
    public function setUser2StepLastUpdate($user2_step_last_update)
    {
        $this->user2_step_last_update = $user2_step_last_update;

        return $this;
    }

    /**
     * Returns the value of field qid
     *
     * @return integer
     */
    public function getQid()
    {
        return $this->qid;
    }

    /**
     * Returns the value of field cid
     *
     * @return integer
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * Returns the value of field question1
     *
     * @return integer
     */
    public function getQuestion1()
    {
        return $this->question1;
    }

    /**
     * Returns the value of field question2
     *
     * @return integer
     */
    public function getQuestion2()
    {
        return $this->question2;
    }

    /**
     * Returns the value of field question3
     *
     * @return integer
     */
    public function getQuestion3()
    {
        return $this->question3;
    }

    /**
     * Returns the value of field question4
     *
     * @return integer
     */
    public function getQuestion4()
    {
        return $this->question4;
    }

    /**
     * Returns the value of field question5
     *
     * @return integer
     */
    public function getQuestion5()
    {
        return $this->question5;
    }

    /**
     * Returns the value of field user1_id
     *
     * @return integer
     */
    public function getUser1Id()
    {
        return $this->user1_id;
    }

    /**
     * Returns the value of field user2_id
     *
     * @return integer
     */
    public function getUser2Id()
    {
        return $this->user2_id;
    }

    /**
     * Returns the value of field user1_state
     *
     * @return string
     */
    public function getUser1State()
    {
        return $this->user1_state;
    }

    /**
     * Returns the value of field user2_state
     *
     * @return string
     */
    public function getUser2State()
    {
        return $this->user2_state;
    }

    /**
     * Returns the value of field user1_correct_answers_count
     *
     * @return integer
     */
    public function getUser1CorrectAnswersCount()
    {
        return $this->user1_correct_answers_count;
    }

    /**
     * Returns the value of field user2_correct_answers_count
     *
     * @return integer
     */
    public function getUser2CorrectAnswersCount()
    {
        return $this->user2_correct_answers_count;
    }

    /**
     * Returns the value of field user1_earned_points
     *
     * @return integer
     */
    public function getUser1EarnedPoints()
    {
        return $this->user1_earned_points;
    }

    /**
     * Returns the value of field user2_earned_points
     *
     * @return integer
     */
    public function getUser2EarnedPoints()
    {
        return $this->user2_earned_points;
    }

    /**
     * Returns the value of field user1_step_last_update
     *
     * @return string
     */
    public function getUser1StepLastUpdate()
    {
        return $this->user1_step_last_update;
    }

    /**
     * Returns the value of field user2_step_last_update
     *
     * @return string
     */
    public function getUser2StepLastUpdate()
    {
        return $this->user2_step_last_update;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('question5', 'QUIZUP\Models\Question', 'qid', array('alias' => 'Question5'));
        $this->belongsTo('question4', 'QUIZUP\Models\Question', 'qid', array('alias' => 'Question4'));
        $this->belongsTo('user1_id', 'QUIZUP\Models\User', 'user_id', array('alias' => 'User1'));
        $this->belongsTo('user2_id', 'QUIZUP\Models\User', 'user_id', array('alias' => 'User2'));
        $this->belongsTo('cid', 'QUIZUP\Models\QuestionCategory', 'cid', array('alias' => 'QuestionCategory'));
        $this->belongsTo('question1', 'QUIZUP\Models\Question', 'qid', array('alias' => 'Question1'));
        $this->belongsTo('question2', 'QUIZUP\Models\Question', 'qid', array('alias' => 'Question2'));
        $this->belongsTo('question3', 'QUIZUP\Models\Question', 'qid', array('alias' => 'Question3'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'quiz';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Quiz[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Quiz
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
