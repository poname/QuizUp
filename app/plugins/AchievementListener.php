<?php

namespace QUIZUP\Plugins;

class AchievementListener
{
    public function beforeSomeTask($event, $myComponent)
    {
//        echo "Here, beforeSomeTask\n";
    }

    public function afterSuccessAction($event, $myComponent)
    {
//        return "Here, afterSuccessAction\n";
    }
}
