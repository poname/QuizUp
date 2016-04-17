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
            'state' => $this->getUserState(),
            'step' => $this->getCurrentStateStep(),
            'remaining_seconds' => ($this->isFinished() || $this->isNotStarted()) ? 0 : time() - strtotime($this->getUserStateLastUpdate())
        );
    }

    public function handleAnswer($answer_index)
    {
        $ret = array(true, '');
        if ($this->isFinished()) {
            $ret = array(false, 'ALREADY_FINISHED');
            return $ret;
        }
        $current_state = $this->getCurrentStateStep();
        if ($current_state > 0) {
            $remaining = time() - $this->getDI()->get('config')->quizup->question_time - strtotime($this->getUserStateLastUpdate());
            if ($remaining < 0) {
                if($this->getCurrentQuestion()->getCorrect() == $answer_index){
                    $property = "User{$this->_side_user_index}";
                    $new_points = $this->$property->getPoints() +
                        $this->getDI()->get('config')->quizup->correct_answer_points * (-1) * $remaining;

                    $this->$property = $this->$property->setPoints($new_points);
                    $ret = array(true);
                }else{
                    $ret = array(false, 'INCORRECT_ANSWER');
                }
            } else {
                $ret = array(false, 'TIME_IS_OVER');
            }
        }
        $this->setCurrentStateStep($current_state+1);
        if(!$this->save()){
            throw new Exception($this->getMessages());
        }
        return $ret;
    }

    public function isNotStarted(){
        return $this->getCurrentStateStep()==0;
    }
    public function isFinished(){
        return $this->getCurrentStateStep() >= count(self::$state_number_mappings) - 1;
    }

    public function getCurrentQuestion(){
        if(!$this->isNotStarted() && !$this->isFinished()){
            $step = $this->getCurrentStateStep();
            $property = "Question{$step}";
            $current_question = $this->$property;
            return $current_question;
        }
        return null;
    }
}
