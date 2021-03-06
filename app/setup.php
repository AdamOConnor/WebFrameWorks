<?php
//----- autoload any classes we are using ------
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config_db.php';

//----- Twig setup --------------
$templatesPath = __DIR__ . '/../templates';

$loader = new Twig_Loader_Filesystem($templatesPath);
$twig = new Twig_Environment($loader);

// set up silex
$app = new Silex\Application();

// register session provider with Silex
//-------------------------------------
$app->register(new Silex\Provider\SessionServiceProvider());

// register Twig with Silex
//-------------------------

$app->register(new Silex\Provider\TwigServiceProvider(), array (
    'twig.path' => $templatesPath
));

//---- monolog
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('adam');
$log->pushHandler(new StreamHandler('C:\laragon\www\Assignment01\WebFrameWorks\logs\log.txt', Logger::DEBUG));
