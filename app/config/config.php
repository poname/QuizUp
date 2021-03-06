<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'quizup',
        'password'    => 'f0GVMn30KNsfnHz0hLlc',
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
        'baseUri'        => '/',  // in a production site , it probably should change to /
        'projectTitle' => 'QUIZUP',
        'lang'           => array(
            'type' => 'fa',
            'dir'  => 'rtl'
        ),
        'webpageURL' => 'http://ccweb.ir/', // in a production site , it probably should change to /
        'quizWebSocketServiceURL' => 'http://ccweb.ir:3000',
        'waitInterval' => 3000 // wait interval between questions!
    ),
    'quizup' => array(
        'question_time' => 10 , //in seconds USELESS!! replaced by application->waitInterval config
        'correct_answer_points' => 1 // point for every question is {{correct_answer_points}} * remaining_seconds,
    )
));
