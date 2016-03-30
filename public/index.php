<?php

error_reporting(E_ALL);

try {

    /**
     * Read the configuration
     */
    $config = include __DIR__ . "/../app/config/config.php";

    /**
     * Read auto-loader
     */
    include __DIR__ . "/../app/config/loader.php";

    /**
     * Read services
     */
    include __DIR__ . "/../app/config/services.php";

    /**
     * Composer auto load
     */
   // include __DIR__ . "/../app/libraries/vendor/autoload.php";

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    if($config->application->production == false) {
        echo $e->getMessage();
    }else{
        //handle errors in production
        echo json_encode(array('status'=>false,'data'=>array('message'=>'INTERNAL_ERROR')));
    }
}
