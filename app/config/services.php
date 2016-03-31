<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            $compiler = $volt->getCompiler();

            //add translator function
            $compiler->addFunction('t',function($resolvedArgs,$exprArgs){
                return '$this->translator->_(' . $resolvedArgs . ')';
            });

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    $connection = new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        'charset' => $config->database->charset
    ));

    $eventsManager = new Phalcon\Events\Manager();

    $logger = new Phalcon\Logger\Adapter\File($config->application->logDir."db.log");

    $eventsManager->attach('db', function ($event, $connection) use ($logger) {
        if ($event->getType() == 'beforeQuery') {
            $logger->log($connection->getSQLStatement(), Phalcon\Logger::INFO);
        }
    });


    $connection->setEventsManager($eventsManager);

    return $connection;
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * Start Translation Manager
 */
$di->set('translator', function() use($config) {
    require $config->application->messagesDir . $config->application->lang->type . ".php";
    return new \Phalcon\Translate\Adapter\NativeArray(array(
        "content" => $messages
    ));
});

/**
 * Instantiate router
 */
$di->set('router', function(){
    return require __DIR__ . '/routes.php';
}, true);

/**
 * Crypt service
 */
$di->set('crypt', function () use ($config) {
    $crypt = new \Phalcon\Crypt();
    $crypt->setKey($config->application->cryptSalt);
    return $crypt;
});

$di->set('dispatcher', function () {

    // Create an events manager
    $eventsManager = new Phalcon\Events\Manager();

    // Listen for events produced in the dispatcher using the Security plugin
    //$eventsManager->attach('dispatch:beforeDispatch', new \QUIZUP\Plugins\ACL());

    // Listen for events produced in the dispatcher using the Security plugin
    $eventsManager->attach('dispatch:beforeExecuteRoute', new \QUIZUP\Plugins\SecurityPlugin());

    // Handle exceptions and not-found exceptions using NotFoundPlugin
    if($config->application->production === true)
        $eventsManager->attach('dispatch:beforeException', new \QUIZUP\Plugins\NotFoundPlugin());

    $dispatcher = new \Phalcon\Mvc\Dispatcher();

    // Assign the events manager to the dispatcher
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

// Register the flash service with custom CSS classes
$di->set('flash', function () {
    $flash = new Phalcon\Flash\Direct(
        array(
            'error'   => 'ui negative message',
            'success' => 'ui positive message',
            'notice'  => 'ui info message',
            'warning' => 'ui warning message'
        )
    );

    return $flash;
});

$di->set('flashSession', function () {
    $flash = new Phalcon\Flash\Session(
        array(
            'error'   => 'ui negative message',
            'success' => 'ui positive message',
            'notice'  => 'ui info message',
            'warning' => 'ui warning message'
        )
    );

    return $flash;
});

/**
 * Custom authentication component
 */
$di->set('auth', function () {
    return new \QUIZUP\Libraries\Auth();
});

$di->set('config', $config,true);

$di->set('uadetect', function () {
    return new \QUIZUP\Libraries\UAParser();
});

$di->set('curl', function () {
    return new \QUIZUP\Libraries\Curl();
});

$di->set('jdf', function () {
    return new \QUIZUP\Libraries\Jdf();
});

$di->set('logger', function () use ($config) {
    return new Phalcon\Logger\Adapter\File($config->application->logDir . "error.log");
});

