<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'quizup',
        'charset'     => 'utf8'
    ),
    'application' => array(
        'production' => false,
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'cacheDir'       => __DIR__ . '/../../app/cache/',
        'messagesDir'    => __DIR__ . '/../../app/messages/',
        'publicDir'    =>  __DIR__ . '/../../public/',
        'logDir'    =>  __DIR__ . '/../../app/log/',
        'librariesDir'   => __DIR__ . '/../../app/libraries/',
        'pluginsDir'   => __DIR__ . '/../../app/plugins/',
        'baseUri'        => '/quizup/',  // in a production site , it probably should change to /
        'projectTitle' => 'QUIZUP',
        'lang'           => array(
            'type' => 'fa',
            'dir'  => 'rtl'
        ),
        'webpageURL' => 'http://localhost/jq/' // in a production site , it probably should change to /
    ),
    'quizup' => array(
        'question_time' => 10 , //in seconds
        'correct_answer_points' => 1 // point for every question is {{correct_answer_points}} * remaining_seconds,
    )
));
