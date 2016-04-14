<?php

namespace QUIZUP\Models\Custom;

use QUIZUP\Libraries\Exceptions\Exception;

class Quiz extends \QUIZUP\Models\Quiz
{
    protected static $state_number_mappings = array(
        0 => 'CREATED',
        1 => 'QUESTION_1',
        2 => 'QUESTION_2',
        3 => 'QUESTION_3',
        4 => 'QUESTION_4',
        5 => 'QUESTION_5',
        6 => 'FINISHED'
    );
    protected $_side_user_id;
    protected $_side_user_index;

    public function setSideUser($user_id){
        $this->_side_user_index = $this->getUserIndex($user_id);
        $this->_side_user_id = $user_id;
    }

    public function getUserIndex($user_id){
        if($this->getUser1Id() == $user_id) return 1;
        if($this->getUser2Id() == $user_id) return 2;
        throw new Exception('user not found in either sides of the quiz');
    }

    public function getCurrentStateStep(){
        $ret = null;
        $flipped = array_flip(self::$state_number_mappings);
        if($this->_side_user_index == 1 && array_key_exists($this->getUser1State(),$flipped)){
            return $flipped[$this->getUser1State()];
        }if($this->_side_user_index == 2 && array_key_exists($this->getUser2State(),$flipped)){
            return $flipped[$this->getUser1State()];
        }

        if($ret===null){
            throw new Exception("invalid user_index passed:({$this->_side_user_index})");
        }
        return $ret;
    }

    public function setCurrentStateStep($new_step){
        if(!array_key_exists($new_step,self::$state_number_mappings)){
            throw new Exception("attempting to set illegal step:({$new_step})");
        }
        if($this->_side_user_index == 1){
            $this->setUser1State(self::$state_number_mappings[$new_step]);
        }

        if($this->_side_user_index == 2){
            $this->setUser1State(self::$state_number_mappings[$new_step]);
        }
    }
}
