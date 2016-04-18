<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/utility/Utility.php';
require_once __DIR__ . '/../app/setup.php';


$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

// get ID from request
//$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);


//----------------------------------------
// default map routes for ordinary user
//----------------------------------------
$app->get('/', controller('Adamoconnorframeworks\Controller', 'main/index'));
$app->get('/register', controller('Adamoconnorframeworks\Controller', 'main/register'));
$app->get('/contact', controller('Adamoconnorframeworks\Controller', 'main/contact'));
$app->get('/sitemap', controller('Adamoconnorframeworks\Controller', 'main/sitemap'));
$app->get('/messages', controller('Adamoconnorframeworks\Controller', 'message/messages'));
$app->get('/error404', controller('Adamoconnorframeworks\Controller', 'message/error404'));

//----------------------------------------
// login actions for users
//----------------------------------------
$app->get('/login', controller('Adamoconnorframeworks\Controller', 'user/login'));
$app->get('/logout', controller('Adamoconnorframeworks\Controller', 'user/logout'));
$app->get('/redirect', controller('Adamoconnorframeworks\Controller', 'user/redirect'));

//----------------------------------------
// secure admin pages
//----------------------------------------
$app->get('/showPrivate', controller('Adamoconnorframeworks\Controller', 'admin/showPrivateMessages'));
$app->get('/admin', controller('Adamoconnorframeworks\Controller', 'admin/index'));
$app->get('/registerUser', controller('Adamoconnorframeworks\Controller', 'admin/register'));
$app->get('/redirectAdmin', controller('Adamoconnorframeworks\Controller', 'admin/redirect'));
$app->post('/deleteUser/{id}', controller('Adamoconnorframeworks\Controller', 'admin/delete'));
$app->post('/details/{id}', controller('Adamoconnorframeworks\Controller', 'admin/detail'));
$app->post('/editUserLogin/{id}', controller('Adamoconnorframeworks\Controller', 'admin/editLogin'));
$app->post('/editUserResume/{id}', controller('Adamoconnorframeworks\Controller', 'admin/editResume'));
$app->post('/adminUpdateUserCv/{id}', controller('Adamoconnorframeworks\Controller', 'admin/updateCv'));
$app->post('/adminUpdateLogin/{id}', controller('Adamoconnorframeworks\Controller', 'admin/updateLogin'));
$app->post('/adminPrivateMessage/{id}', controller('Adamoconnorframeworks\Controller', 'admin/privateMessage'));
$app->get('/adminMessages', controller('Adamoconnorframeworks\Controller', 'message/adminMessages'));
$app->get('/adminCreateMessage', controller('Adamoconnorframeworks\Controller', 'admin/createMessage'));
$app->post('/redirectAdminForm', controller('Adamoconnorframeworks\Controller', 'admin/processRegistrationFormAdmin'));

$app->post('/deleteJob/{id}', controller('Adamoconnorframeworks\Controller', 'admin/deleteJob'));
$app->post('/processForm', controller('Adamoconnorframeworks\Controller', 'student/processResume'));
$app->post('/login', controller('Adamoconnorframeworks\Controller', 'user/processLogin'));
$app->post('/redirectForm', controller('Adamoconnorframeworks\Controller', 'user/processRegistrationForm'));
$app->get('/createAdminMessage', controller('Adamoconnorframeworks\Controller', 'message/createAdminPrivateMessage'));
$app->get('/createStudentMessage', controller('Adamoconnorframeworks\Controller', 'message/createStudentPrivateMessage'));
$app->post('/processMessage', controller('Adamoconnorframeworks\Controller', 'message/submit'));
$app->post('/editMessage/{id}', controller('Adamoconnorframeworks\Controller', 'message/messageEdit'));
$app->post('/deleteMessage/{id}', controller('Adamoconnorframeworks\Controller', 'message/delete'));
$app->post('/processMessageUpdateForm', controller('Adamoconnorframeworks\Controller', 'message/update'));
$app->post('/privateMessageUpdateForm', controller('Adamoconnorframeworks\Controller', 'message/privateUpdate'));
$app->post('/privateMessage', controller('Adamoconnorframeworks\Controller', 'message/privateMessage'));
$app->post('/privateDeleteMessage/{id}', controller('Adamoconnorframeworks\Controller', 'message/privateDelete'));
$app->post('/privateEditMessage/{id}', controller('Adamoconnorframeworks\Controller', 'message/privateMessageEdit'));
$app->get('/employment', controller('Adamoconnorframeworks\Controller', 'admin/employment'));
$app->get('/pendingJob', controller('Adamoconnorframeworks\Controller', 'admin/pendingJob'));
$app->post('/setStatusOfJob/{id}', controller('Adamoconnorframeworks\Controller', 'admin/jobStatus'));
//-----------------------------------------
// secure student page
//-----------------------------------------
$app->get('/student', controller('Adamoconnorframeworks\Controller', 'student/index'));
$app->get('/studentCv', controller('Adamoconnorframeworks\Controller', 'student/cv'));
$app->get('/showPrivateMessagesStudent', controller('Adamoconnorframeworks\Controller', 'student/showPrivateMessages'));
$app->get('/jobs', controller('Adamoconnorframeworks\Controller', 'student/jobs'));

//-----------------------------------------
// secure employer page
//-----------------------------------------
$app->get('/employer', controller('Adamoconnorframeworks\Controller', 'employer/index'));
$app->get('/employerRecords', controller('Adamoconnorframeworks\Controller', 'employer/codes'));
$app->post('/processJob', controller('Adamoconnorframeworks\Controller', 'employer/processJob'));
//-----------------------------------------
// error pages if users enter url
//-----------------------------------------
$app->error(function (\Exception $e, $code) use ($app) {
    switch($code) {
      case 404:
            $heading = 'Sorry about this !!';
            $message = 'But the requested page could not be found.';
            return \Adamoconnorframeworks\Controller\MainController::error404($app, $message, $heading);
        default:
            $heading = 'Sorry about this !!';
            $message = 'We are sorry, but something went wrong.';
            return \Adamoconnorframeworks\Controller\MainController::error404($app, $message, $heading);
    }
});
//run the silex front controller
//------------------------------
$app->run();
  
