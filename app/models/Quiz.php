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
     * @var string
     */
    protected $state;

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
    protected $user_id1;

    /**
     *
     * @var integer
     */
    protected $user_id2;

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
     * Method to set the value of field state
     *
     * @param string $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

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
     * Method to set the value of field user_id1
     *
     * @param integer $user_id1
     * @return $this
     */
    public function setUserId1($user_id1)
    {
        $this->user_id1 = $user_id1;

        return $this;
    }

    /**
     * Method to set the value of field user_id2
     *
     * @param integer $user_id2
     * @return $this
     */
    public function setUserId2($user_id2)
    {
        $this->user_id2 = $user_id2;

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
     * Returns the value of field state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
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
     * Returns the value of field user_id1
     *
     * @return integer
     */
    public function getUserId1()
    {
        return $this->user_id1;
    }

    /**
     * Returns the value of field user_id2
     *
     * @return integer
     */
    public function getUserId2()
    {
        return $this->user_id2;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('question5', 'QUIZUP\Models\Question', 'qid', array('alias' => 'Question'));
        $this->belongsTo('question4', 'QUIZUP\Models\Question', 'qid', array('alias' => 'Question'));
        $this->belongsTo('cid', 'QUIZUP\Models\QuestionCategory', 'cid', array('alias' => 'QuestionCategory'));
        $this->belongsTo('question1', 'QUIZUP\Models\Question', 'qid', array('alias' => 'Question'));
        $this->belongsTo('user_id1', 'QUIZUP\Models\User', 'user_id', array('alias' => 'User'));
        $this->belongsTo('question2', 'QUIZUP\Models\Question', 'qid', array('alias' => 'Question'));
        $this->belongsTo('user_id2', 'QUIZUP\Models\User', 'user_id', array('alias' => 'User'));
        $this->belongsTo('question3', 'QUIZUP\Models\Question', 'qid', array('alias' => 'Question'));
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

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'qid' => 'qid',
            'state' => 'state',
            'cid' => 'cid',
            'question1' => 'question1',
            'question2' => 'question2',
            'question3' => 'question3',
            'question4' => 'question4',
            'question5' => 'question5',
            'user_id1' => 'user_id1',
            'user_id2' => 'user_id2'
        );
    }

}
