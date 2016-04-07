<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/utility/Utility.php';
require_once __DIR__ . '/../app/setup.php';

//----------------------------------------
// login actions for users
//----------------------------------------
$app->get('/login', controller('Adamoconnorframeworks\Controller', 'user/login'));
$app->get('/logout', controller('Adamoconnorframeworks\Controller', 'user/logout'));
$app->get('/redirect', controller('Adamoconnorframeworks\Controller', 'user/redirect'));

//----------------------------------------
// default map routes for ordinary user
//----------------------------------------
$app->get('/', controller('Adamoconnorframeworks\Controller', 'main/index'));
$app->get('/register', controller('Adamoconnorframeworks\Controller', 'main/register'));
$app->get('/contact', controller('Adamoconnorframeworks\Controller', 'main/contact'));
$app->get('/sitemap', controller('Adamoconnorframeworks\Controller', 'main/sitemap'));
//$app->get('/studentredirect', controller('Adamoconnorframeworks\Controller', 'student/redirect'));
//----------------------------------------
// secure admin pages
//----------------------------------------
$app->get('/admin', controller('Adamoconnorframeworks\Controller', 'admin/index'));
$app->get('/adminCodes', controller('Adamoconnorframeworks\Controller', 'admin/codes'));

$app->post('/processForm', controller('Adamoconnorframeworks\Controller', 'student/processResume'));
$app->post('/login', controller('Adamoconnorframeworks\Controller', 'user/processLogin'));
$app->post('/redirectForm', controller('Adamoconnorframeworks\Controller', 'user/processRegistrationForm'));


//-----------------------------------------
// secure student page
//-----------------------------------------
$app->get('/student', controller('Adamoconnorframeworks\Controller', 'student/index'));
$app->get('/studentCv', controller('Adamoconnorframeworks\Controller', 'student/cv'));
//-----------------------------------------
// secure employer page
//-----------------------------------------
$app->get('/employer', controller('Adamoconnorframeworks\Controller', 'employer/index'));
$app->get('/employerRecords', controller('Adamoconnorframeworks\Controller', 'employer/codes'));
//-----------------------------------------
// error pages if users enter url
//-----------------------------------------
/*$app->error(function (\Exception $e, $code) use ($app) {
    switch($code) {
      case 404:
        $message = 'The requested page could not be found.';
        return error404($app, $message);
        default:
        $message = 'We are sorry, but something went wrong.';
          return error404($app, $message);
    }
});*/

//run the silex front controller
//------------------------------
$app->run();
  
