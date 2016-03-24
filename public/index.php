<?php
use Itb\MainController;

require_once __DIR__ . '/../app/setup.php';

$app->get('/', \Itb\Utility::controller('Itb', 'main/index'));
$app->get('/register', \Itb\Utility::controller('Itb', 'main/register'));
$app->get('/contact', \Itb\Utility::controller('Itb', 'main/contact'));
$app->get('/sitemap', \Itb\Utility::controller('Itb', 'main/sitemap'));

// error page - 404
$app->error(function (\Exception $e, $code) use ($app) {
    switch($code) {
        case 404:
            $message = 'The requested page could not be found.';
            return \Itb\MainController::error404($app, $message);
        default:
            $message = 'We are sorry, but something went wrong.';
            return \Itb\MainController::error404($app, $message);
    }
});

//run the silex front controller
//------------------------------
$app->run();