<?php

namespace QUIZUP\Models;

class Question extends \Phalcon\Mvc\Model
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
     * @var string
     */
    protected $description;

    /**
     *
     * @var string
     */
    protected $ans1;

    /**
     *
     * @var string
     */
    protected $ans2;

    /**
     *
     * @var string
     */
    protected $ans3;

    /**
     *
     * @var string
     */
    protected $ans4;

    /**
     *
     * @var integer
     */
    protected $correct;

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
     * Method to set the value of field description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Method to set the value of field ans1
     *
     * @param string $ans1
     * @return $this
     */
    public function setAns1($ans1)
    {
        $this->ans1 = $ans1;

        return $this;
    }

    /**
     * Method to set the value of field ans2
     *
     * @param string $ans2
     * @return $this
     */
    public function setAns2($ans2)
    {
        $this->ans2 = $ans2;

        return $this;
    }

    /**
     * Method to set the value of field ans3
     *
     * @param string $ans3
     * @return $this
     */
    public function setAns3($ans3)
    {
        $this->ans3 = $ans3;

        return $this;
    }

    /**
     * Method to set the value of field ans4
     *
     * @param string $ans4
     * @return $this
     */
    public function setAns4($ans4)
    {
        $this->ans4 = $ans4;

        return $this;
    }

    /**
     * Method to set the value of field correct
     *
     * @param integer $correct
     * @return $this
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;

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
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the value of field ans1
     *
     * @return string
     */
    public function getAns1()
    {
        return $this->ans1;
    }

    /**
     * Returns the value of field ans2
     *
     * @return string
     */
    public function getAns2()
    {
        return $this->ans2;
    }

    /**
     * Returns the value of field ans3
     *
     * @return string
     */
    public function getAns3()
    {
        return $this->ans3;
    }

    /**
     * Returns the value of field ans4
     *
     * @return string
     */
    public function getAns4()
    {
        return $this->ans4;
    }

    /**
     * Returns the value of field correct
     *
     * @return integer
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('qid', 'QUIZUP\Models\Quiz', 'question5', array('alias' => 'Quiz5'));
        $this->hasMany('qid', 'QUIZUP\Models\Quiz', 'question4', array('alias' => 'Quiz4'));
        $this->hasMany('qid', 'QUIZUP\Models\Quiz', 'question1', array('alias' => 'Quiz1'));
        $this->hasMany('qid', 'QUIZUP\Models\Quiz', 'question2', array('alias' => 'Quiz2'));
        $this->hasMany('qid', 'QUIZUP\Models\Quiz', 'question3', array('alias' => 'Quiz3'));
        $this->belongsTo('cid', 'QUIZUP\Models\QuestionCategory', 'cid', array('foreignKey' => true,'alias' => 'QuestionCategory'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'question';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Question[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Question
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
