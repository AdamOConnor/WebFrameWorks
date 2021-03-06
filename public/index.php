<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/utility/Utility.php';
require_once __DIR__ . '/../app/setup.php';

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
$app->post('/login', controller('Adamoconnorframeworks\Controller', 'user/processLogin'));
$app->post('/redirectForm', controller('Adamoconnorframeworks\Controller', 'user/processRegistrationForm'));

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
$app->get('/createAdminMessage', controller('Adamoconnorframeworks\Controller', 'message/createAdminPrivateMessage'));
$app->post('/processMessage', controller('Adamoconnorframeworks\Controller', 'message/submit'));
$app->get('/employment', controller('Adamoconnorframeworks\Controller', 'admin/employment'));
$app->get('/pendingJob', controller('Adamoconnorframeworks\Controller', 'admin/pendingJob'));
$app->post('/setStatusOfJob/{id}', controller('Adamoconnorframeworks\Controller', 'admin/jobStatus'));

//-----------------------------------------
// secure student page
//-----------------------------------------
$app->get('/student', controller('Adamoconnorframeworks\Controller', 'student/index'));
$app->get('/uploadImage', controller('Adamoconnorframeworks\Controller', 'student/uploadImage'));
$app->get('/upload', controller('Adamoconnorframeworks\Controller', 'student/upload'));
$app->get('/studentCv', controller('Adamoconnorframeworks\Controller', 'student/cv'));
$app->get('/showPrivateMessagesStudent', controller('Adamoconnorframeworks\Controller', 'student/showPrivateMessages'));
$app->get('/jobs', controller('Adamoconnorframeworks\Controller', 'student/jobs'));
$app->post('/applyForJob/{id}', controller('Adamoconnorframeworks\Controller', 'job/apply'));
$app->get('/createStudentMessage', controller('Adamoconnorframeworks\Controller', 'message/createStudentPrivateMessage'));
$app->post('/processForm', controller('Adamoconnorframeworks\Controller', 'student/processResume'));

//-----------------------------------------
// secure employer page's
//-----------------------------------------
$app->get('/employer', controller('Adamoconnorframeworks\Controller', 'employer/index'));
$app->get('/employerRecords', controller('Adamoconnorframeworks\Controller', 'employer/records'));
$app->post('/processJob', controller('Adamoconnorframeworks\Controller', 'employer/processJob'));
$app->get('/showPrivateMessagesEmployer', controller('Adamoconnorframeworks\Controller', 'employer/showPrivateMessages'));
$app->post('/getAll/{id}', controller('Adamoconnorframeworks\Controller', 'pdf/index'));
$app->get('/redirectJob', controller('Adamoconnorframeworks\Controller', 'pdf/redirect'));
$app->get('/createEmployerMessage', controller('Adamoconnorframeworks\Controller', 'message/createEmployerPrivateMessage'));

//----------------------------------------
// messages controllers
//----------------------------------------
$app->post('/editMessage/{id}', controller('Adamoconnorframeworks\Controller', 'message/messageEdit'));
$app->post('/deleteMessage/{id}', controller('Adamoconnorframeworks\Controller', 'message/delete'));
$app->post('/processMessageUpdateForm', controller('Adamoconnorframeworks\Controller', 'message/update'));
$app->post('/privateMessageUpdateForm', controller('Adamoconnorframeworks\Controller', 'message/privateUpdate'));
$app->post('/privateMessage', controller('Adamoconnorframeworks\Controller', 'message/privateMessage'));
$app->post('/privateDeleteMessage/{id}', controller('Adamoconnorframeworks\Controller', 'message/privateDelete'));
$app->post('/privateEditMessage/{id}', controller('Adamoconnorframeworks\Controller', 'message/privateMessageEdit'));

//-----------------------------------------
// error pages if users enter url
//-----------------------------------------

$app->error(function (\Exception $e, $code) use ($app) {
    $errorController = new Adamoconnorframeworks\Controller\ErrorController();
    return $errorController->errorAction($app, $code);
});
//run the silex front controller
//------------------------------
//$app['debug']=true;
$app->run();
