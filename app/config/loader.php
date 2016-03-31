<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces(array(
    'QUIZUP\Controllers' => $config->application->controllersDir,
//    'QUIZUP\Controllers\User' => $config->application->controllersDir.'user/',
//    'QUIZUP\Controllers\Login' => $config->application->controllersDir.'login/',
//    'QUIZUP\Controllers\Signup' => $config->application->controllersDir.'signup/',
//    'QUIZUP\Controllers\Main' => $config->application->controllersDir.'main/',
//    'QUIZUP\Controllers\Category' => $config->application->controllersDir.'category/',


    'QUIZUP\Models' =>$config->application->modelsDir,
    'QUIZUP\Libraries' =>$config->application->librariesDir,
    'QUIZUP\Plugins' =>$config->application->pluginsDir,

    'QUIZUP\Libraries\Exceptions' =>dirname($config->application->librariesDir).'/Exceptions',
))->register();
