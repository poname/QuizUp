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

    public function getStatus($persist = true){
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
        $current_question = null;
        if(!$this->isNotStarted() && !$this->isFinished()){
            $property = "Question{$this->getCurrentStateStep()}";
            $current_question = $this->$property->toArray();
            unset($current_question['correct']); // we don't want to send correct answer to client, do we? :)
        }
        return array(
            'state' => $this->getUserState(),
            'step' => $this->getCurrentStateStep(),
            'earned_points' => $this->getCurrentEarnedPoints(),
            'current_question' => $current_question,
            'correct_answers_count' => $this->getUserCorrectAnswersCount(),
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
            $remaining = $this->getDI()->get('config')->quizup->question_time + strtotime($this->getUserStateLastUpdate()) - time();
            if ($remaining > 0) {
                if($this->getCurrentQuestion()->getCorrect() == $answer_index){
                    $this->setCurrentEarnedPoints(
                        $this->getCurrentEarnedPoints() +
                        $this->getDI()->get('config')->quizup->correct_answer_points * $remaining
                    );
                    $this->incrementCorrectAnswers();
                    $ret = array(true);
                }else{
                    $ret = array(false, 'INCORRECT_ANSWER');
                }
            } else {
                $ret = array(false, 'TIME_IS_OVER');
            }
        }
        $this->setCurrentStateStep($current_state+1);

        //if we're in the last step , update the user points
        if($this->isFinished()){
            $property = "User{$this->_side_user_index}";
            $new_points = $this->$property->getPoints() + $this->getCurrentEarnedPoints();
            $this->$property = $this->$property->setPoints($new_points);
        }
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

    public function getCurrentEarnedPoints(){
        if($this->_side_user_index == 1 ) return $this->getUser1EarnedPoints();
        if($this->_side_user_index == 2 ) return $this->getUser2EarnedPoints();
        throw new Exception('invalid side user index' . var_export($this->_side_user_index, true));
    }

    public function setCurrentEarnedPoints($points){
        if($this->_side_user_index == 1 ) return $this->setUser1EarnedPoints($points);
        if($this->_side_user_index == 2 ) return $this->setUser2EarnedPoints($points);
        throw new Exception('invalid side user index' . var_export($this->_side_user_index, true));
    }

    public function incrementCorrectAnswers(){
        if($this->_side_user_index == 1 ) return $this->setUser1CorrectAnswersCount($this->getUser1CorrectAnswersCount()+1);
        if($this->_side_user_index == 2 ) return $this->setUser2CorrectAnswersCount($this->getUser2CorrectAnswersCount()+1);
        throw new Exception('invalid side user index' . var_export($this->_side_user_index, true));
    }

    public function getUserCorrectAnswersCount(){
        if($this->_side_user_index == 1 ) return $this->getUser1CorrectAnswersCount();
        if($this->_side_user_index == 2 ) return $this->getUser2CorrectAnswersCount();
        throw new Exception('invalid side user index' . var_export($this->_side_user_index, true));

    }

    public function getResult(){
        if(!$this->isFinished())
            throw new Exception('tried to call get result when the quiz is not over!!');

        $winnerIndex = 1;
        $looserIndex = 2;
        if($this->getUser2EarnedPoints()>$this->getUser1EarnedPoints()){
            $winnerIndex =2 ;
            $looserIndex = 1;
        }
        $winnerUserProperty = "User$winnerIndex";
        $looserUserProperty = "User$looserIndex";
        return array(
            'winner' => $this->$winnerUserProperty,
            'looser' => $this->$looserUserProperty
        );
    }
    public function afterUpdate(){

        $result = $this->getResult();

        $mail = new \PHPMailer();
        // Set PHPMailer to use the sendmail transport
        $mail->isSendmail();
        $mail->setFrom('noreplay@ccweb.ir', 'QuizUP');
        $mail->addAddress($result['winner']->getEmail(), "{$result['winner']->getName()} {$result['winner']->getFamily()}");
        $mail->Subject = 'Quiz Invitation';
        $mail->msgHTML($this->view->getRender('emails','quiz-invitation',array(
            'full_name'=>$result['winner']->getName(),
            'opponent_name' => $result['looser']->getName(),
        )));
        $mail->send();
    }
}
