<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'shop',
        'charset'     => 'utf8'
    ),
    'application' => array(
        'production' => true,
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
        'webpageURL' => 'http://localhost/quizup/' // in a production site , it probably should change to /
    )
));
