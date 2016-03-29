<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/utility/Utility.php';

require_once __DIR__ . '/../app/setup.php';

//----------------------------------------
// login actions for users
//----------------------------------------
$app->get('/login',  controller('Adamoconnorframeworks\Controller', 'user/login'));
$app->get('/logout',  controller('Adamoconnorframeworks\Controller', 'user/logout'));
//----------------------------------------
// default map routes for ordinary user
//----------------------------------------
$app->get('/', controller('Adamoconnorframeworks\Controller', 'main/index'));
$app->get('/register', controller('Adamoconnorframeworks\Controller', 'main/register'));
$app->get('/contact', controller('Adamoconnorframeworks\Controller', 'main/contact'));
$app->get('/sitemap', controller('Adamoconnorframeworks\Controller', 'main/sitemap'));

//----------------------------------------
// secure admin pages
//----------------------------------------
$app->get('/admin',  controller('Adamoconnorframeworks\Controller', 'admin/index'));
$app->get('/adminCodes',  controller('Adamoconnorframeworks\Controller', 'admin/codes'));

$app->post('/login',  controller('Adamoconnorframeworks\Controller', 'user/processLogin'));
//-----------------------------------------
// secure student page
//-----------------------------------------

//-----------------------------------------
// secure employer page
//-----------------------------------------

//-----------------------------------------
// error pages if users enter url
//-----------------------------------------
//$app->error(function (\Exception $e, $code) use ($app) {
 //   switch($code) {
//        case 404:
   //         $message = 'The requested page could not be found.';
       //     return error404($app, $message);
     //   default:
       //     $message = 'We are sorry, but something went wrong.';
       //     return error404($app, $message);
  //  }
//});

//run the silex front controller
//------------------------------
$app->run();