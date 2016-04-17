<?php
/**
 * Created by IntelliJ IDEA.
 * User: Peyman Zeynali
 * Date: 4/15/2016
 * Time: 11:05 AM
 */

namespace QUIZUP\Controllers;

use QUIZUP\Models\User;
class RankingController  extends ControllerBase
{
    public function initialize(){
        parent::initialize();
    }
    public function indexAction(){

        //$users = User::find() or array();

        $users_ranked = User::find(
            array(
                "order" => "points",
                "limit" => 3
            )
        ) or array();

        //$rankings = array_reverse(usort($users, 'ranking_sort'));
      //  $three_most_rankings = array_slice( $users_ranked, 0, 3);
        //$this->view->setVar('rankings', $three_most_rankings);
        $this->view->setVar('rankings', $users_ranked);
        echo 'err';
        echo count($users_ranked);
    }

    public function moreAction(){

        $users = User::find() or array();
        $users_ranked = User::find(
            array(
                "order" => "points DESC"
            )
        ) or array();

        $this->view->setVar('rankings', $users_ranked);
    }
}