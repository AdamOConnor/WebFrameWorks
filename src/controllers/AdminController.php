<?php
/**
 * @Author Adam O'Connor
 * admin controller for lecturer
 */
namespace Adamoconnorframeworks\Controller;

use Adamoconnorframeworks\Model\Resume;
use Adamoconnorframeworks\Model\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController
 * @package Adamoconnorframeworks\Controller
 */
class AdminController
{
    /**
     * allow access to admin/index
     * allows lecturer
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

        $userRepository = new User();
       // $getStudentRole = $userRepository->getUserByStudentRole('Student');
        $getAllDetails = $userRepository->getAll();

        // store username into args array
        // and rolename
        $argsArray = array(
            'users' => $getAllDetails,
            'username' => $username,
            'roleName' => 'Lecturer'
        );

        // template for admin index
        $templateName = 'admin/index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
    
    /**
     * allow access to the codesAction
    * @param Request $request
    * @param Application $app
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
    public function codesAction(Request $request, Application $app)
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
        // and rolename
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Lecturer'
        );

        // template for admin codes.
        $templateName = 'admin/codes';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * allow access to the codesAction
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function detailAction(Request $request, Application $app, $id)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $userRepository = new User();
        $user = $userRepository->getOneById($id);
        $cvRepository = new Resume();
        $usersCv = $cvRepository->getOneById($id);

        // store username into args array
        // and rolename
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Lecturer',
            'userDetails' => $user,
            'userCvDetails' => $usersCv
        );

        // template for admin codes.
        $templateName = 'admin/detail';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function deleteAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $userRepository = User::delete($id);
        
        if($userRepository != null){

            $userRepository = new User();
            // $getStudentRole = $userRepository->getUserByStudentRole('Student');
            $getAllDetails = $userRepository->getAll();

            // store username into args array
            // and rolename
            $argsArray = array(
                'users' => $getAllDetails,
                'username' => $username,
                'roleName' => 'Lecturer'
            );

            // template for admin index
            $templateName = 'admin/index';
           
        } else {
            $templateName = 'messages';
            $argsArray = array(
                'username' => $username,
                'roleName' => $currentUser->getRole(),
                'otherMessage' => 'there was a problem delete message with id ' . $id . 'to the database ...'
            );
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
    
    

    /**
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editResumeAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);

        $resumeDetails = Resume::getOneByUsername($id);
        $userDetails = User::getOneById($id);
        

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Lecturer',
            'resumeDetails' => $resumeDetails,
            'userDetails' => $userDetails
        );

        // template for student records
        $templateName = 'admin/updateCv';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editLoginAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $userDetails = User::getOneById($id);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Lecturer',
            'userDetails' => $userDetails
        );

        // template for student records
        $templateName = 'admin/updateDetails';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function  updateLoginAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $emailId = $request->get('emailId');
        $user = $request->get('username');
        $password = $request->get('password');
        $rePassword = $request->get('repassword');
        $status = $request->get('status');
        $employmentStatus = $request->get('role');
        
        if($password != $rePassword)
        {
            
        }
        else {
            $updateUser = new User();
            // set each of the fields with the registration form data.
            $updateUser->setId($emailId);
            $updateUser->setUsername($user);
            $updateUser->setPassword($password);
            $updateUser->setStatus($status);
            $updateUser->setRole($employmentStatus);
        }

        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Lecturer',
        );

        // template for student records
        $templateName = 'admin/updateDetails';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

}
