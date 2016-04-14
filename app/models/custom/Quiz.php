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

    public function getUserId(){
        return $this->_side_user_id;
    }

    public function getUserState(){
        if($this->_side_user_index == 1) return $this->getUser1State();
        if($this->_side_user_index == 2) return $this->getUser2State();
        throw new Exception('cannot get user state:'.$this->_side_user_index);
    }

    public function setUserState($new_state){
        if($this->_side_user_index == 1) return $this->setUser1State($new_state);
        if($this->_side_user_index == 2) return $this->setUser1State($new_state);
        throw new Exception('cannot get user state:'.$this->_side_user_index);
    }

    public function getUserIndex($user_id){
        if($this->getUser1Id() == $user_id) return 1;
        if($this->getUser2Id() == $user_id) return 2;
        throw new Exception('user not found in either sides of the quiz');
    }

    public function getUserStateLastUpdate(){
        if($this->_side_user_index == 1) return $this->getUser1StepLastUpdate();
        if($this->_side_user_index == 2) return $this->getUser2StepLastUpdate();
        throw new Exception('cannot get user state:'.$this->_side_user_index);

    }

    public function getCurrentStateStep(){
        $flipped = array_flip(self::$state_number_mappings);
        return $flipped[$this->getUserState()];
    }

    public function setCurrentStateStep($new_step){
        if(!array_key_exists($new_step,self::$state_number_mappings)){
            throw new Exception("attempting to set illegal step:({$new_step})");
        }
        if($this->_side_user_index == 1){
            $this->setUser1State(self::$state_number_mappings[$new_step]);
            $this->setUser1StepLastUpdate(date('Y-m-d H:i:s', time()));
        }

        if($this->_side_user_index == 2){
            $this->setUser2State(self::$state_number_mappings[$new_step]);
            $this->setUser2StepLastUpdate(date('Y-m-d H:i:s', time()));
        }
    }

    public function getStatus(){
        $current_step = $this->getCurrentStateStep();
        $last_update = strtotime($this->getUserStateLastUpdate());
        $to_move = (int)((time() - $last_update)/$this->getDI()->get('config')->quizup->question_time);
        if(self::$state_number_mappings[$current_step]!='CREATED' && self::$state_number_mappings[$current_step]!='FINISHED'){
            $next_step =
                $current_step + $to_move >= count(self::$state_number_mappings)
                    ? count(self::$state_number_mappings)-1
                    : $current_step + $to_move;


            $this->setCurrentStateStep($next_step);
            if(!$this->save()){
                throw new Exception(var_export($this->getMessages(), true));
            }
        }
        return array(
            'state' => $this->getUser1State(),
            'step' => $this->getCurrentStateStep(),
            'remaining_seconds' => time() - strtotime($this->getUser1StepLastUpdate())
        );
    }
}
