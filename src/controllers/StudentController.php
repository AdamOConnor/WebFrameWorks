<?php

/**
 * the student controller controls all student
 * interactivity throughout the login.
 */
namespace Adamoconnorframeworks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Adamoconnorframeworks\Model\User;
use Adamoconnorframeworks\Model\Resume;
use Adamoconnorframeworks\Model\Admin;
use Adamoconnorframeworks\Model\PrivateMessage;
use Adamoconnorframeworks\Model\Pending;

/**
 * simple authentication getting specific links
 * Class StudentController
 * @package Adamoconnorframeworks\Controller
 */
class StudentController
{

    /**
     * index action for the student login.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }
        
        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Student'
        );

        // template used for student index
        $templateName = 'student/index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * records action for student,
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function cvAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);
        $email = $currentUser->getEmail();
        $sampleData = Resume::getOneByEmail($email);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Student',
            'resumeDetails' => $sampleData
        );

        // template for student records
        $templateName = 'student/cvForm';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * this is the action used for processing
     * the resume form.
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processResumeAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);
       // $user = $currentUser->getEmail();
       // $sampleData = Resume::getOneByUsername($user);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $email = $request->get('emailAddress');
        $firstName = $request->get('firstname');
        $surname = $request->get('surname');
        $number = $request->get('number');
        $image = $request->get('image');
        $employmentStatus = $request->get('status');
        $addressLine01 = $request->get('addressLine01');
        $addressLine02 = $request->get('addressLine02');
        $city = $request->get('city');
        $eircode = $request->get('eircode');
        $country = $request->get('country');
        $employment = $request->get('employment');
        $qualifications = $request->get('qualifications');
        $skills = $request->get('skills');

        $updateCv = new Resume();

        // set each of the fields with the registration form data.
        $updateCv->setId($currentUser->getId());
        $updateCv->setEmail($email);
        $updateCv->setName($firstName);
        $updateCv->setSurname($surname);
        $updateCv->setNumber($number);
        $updateCv->setImage('upload/'.$image);
        $updateCv->setStatus($employmentStatus);
        $updateCv->setAddress($addressLine01);
        $updateCv->setTown($addressLine02);
        $updateCv->setCity($city);
        $updateCv->setEircode($eircode);
        $updateCv->setCountry($country);
        $updateCv->setEmployment($employment);
        $updateCv->setQualifications($qualifications);
        $updateCv->setSkills($skills);

        $success = Resume::update($updateCv);
     
        if ($success) {
            $templateName = 'redirect';
            $argsArray = array(
                'headingMessage' => 'Your cv has now been updated !!! ',
                'otherMessage' => 'Thank you for submitting your cv.',
                'username' => $username,
                'roleName' => 'Student'
            );
        } // otherwise show this message
        else {
            $templateName = 'redirect';
            $argsArray = array(
                'headingMessage' => 'Woops !!!',
                'otherMessage' => 'Sorry something went wrong!! please try again.',
                'username' => $username,
                'roleName' => 'Student',
            );
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * redirect the user if the form has
     * succeeded to process and is saved
     * in the database.
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function redirectAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $argsArray = array(
            'headingMessage' => 'Your cv has now been updated !!!',
            'otherMessage' => 'Thank you for submitting your cv.'
        );

        // template for student records
        $templateName = 'redirect';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * private message page
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function privateMessageAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $sending = Admin::getOneByUsername($username);
        $receiver = User::getOneById($id);


        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $argsArray = array(
            'username' => $username,
            'roleName' => $sending->getRole(),
            'receivingUser' => $receiver,
            'sendingUser' => $sending
        );

        // template for student records
        $templateName = 'student/privateMessage';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * show private messages to students action.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function showPrivateMessagesAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);
        $messages = PrivateMessage::getAll();
        $admin = Admin::getAll();

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => $currentUser->getRole(),
            'messages' => $messages,
            'student' => $currentUser,
            'admin' => $admin
        );

        // template used for student index
        $templateName = 'student/listPrivateMessages';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * private message page
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function studentPrivateMessageAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $sending = User::getOneByUsername($username);
        $receiver = Admin::getOneById($id);
       
        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $argsArray = array(
            'username' => $username,
            'roleName' => $sending->getRole(),
            'receivingUser' => $receiver,
            'sendingUser' => $sending
        );

        // template for student records
        $templateName = 'admin/privateMessage';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * action to go to list jobs page.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function jobsAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        if ($currentUser == null) {
            $currentUser = Admin::getOneByUsername($username);
        }

        $pendingJobs = Pending::getAll();

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        // and rolename

        $now = new \DateTime();
        $timestamp = $now->getTimestamp();
        
        $argsArray = array(
            'username' => $username,
            'roleName' => $currentUser->getRole(),
            'jobs' => $pendingJobs,
            'time' => $timestamp
        );

        // template for admin index
        $templateName = 'student/listJobs';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * action to go to list jobs page.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function submitApplicationAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        if ($currentUser == null) {
            $currentUser = Admin::getOneByUsername($username);
        }

        $pendingJobs = Pending::getAll();

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        // and rolename
        $argsArray = array(
            'username' => $username,
            'roleName' => $currentUser->getRole(),
            'jobs' => $pendingJobs
        );

        // template for admin index
        $templateName = 'student/listJobs';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}
