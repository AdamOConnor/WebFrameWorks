<?php
/**
 * @Author Adam O'Connor 
 * Webframeworks project.
 */
namespace Adamoconnorframeworks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Adamoconnorframeworks\Model\User;
use Adamoconnorframeworks\Model\Resume;
use Adamoconnorframeworks\Model\Admin;

/**
 * Class UserController
 * @package Adamoconnorframeworks\Controller
 */
class UserController
{
    
    /**
     * action used for the Post route of /processLogin
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function processLoginAction(Request $request, Application $app)
    {
        // retrieve 'name' from GET params in Request object
        $username = $request->get('username');
        $password = $request->get('password');

        $isLoggedIn = User::canFindMatchingUsernameAndPassword($username, $password);
        $roleName = User::canFindSpecificRoleOfUser($username);
        $isAdminLoggedIn = Admin::canFindMatchingUsernameAndPassword($username, $password);
        
        // if the user is logged in do this.
        if ($isLoggedIn) {
            // get the role number of the user that has logged in.
            switch ($roleName) {
                case 'Student':
                    $app['session']->set('user', array('username' => $username));
                    return $app->redirect('/student');
                case 'Employer':
                    $app['session']->set('user', array('username' => $username));
                    return $app->redirect('/employer');
                default:
                    return $app->redirect('/error404');
            }
        }

        else if($isAdminLoggedIn) {
            $app['session']->set('user', array('username' => $username));
            return $app->redirect('/admin');
        }
        else {
            $templateName = 'index';
            $argsArray = array(
                'errorMessage' => 'bad username or password - please re-enter'
            );

            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * process registration form
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processRegistrationFormAction(Request $request, Application $app)
    {
        // get text from each field on the registration form
        $accountType = $request->get('account');
        $emailId = $request->get('email');
        $username = $request->get('username');
        $password = $request->get('password');
        $rePassword = $request->get('rePassword');
        $status = $request->get('status');

        if($password != $rePassword || $rePassword != $password) {

            $templateName = 'register';
            $argsArray = array(
                'errorMessage' => 'Sorry the passwords do not match !!'
            );
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }

        $checkDetails = User::checkRegistration($emailId, $username);

        if ($checkDetails == null) {
            // instantiate the class needed
            $newUser = new User();

            // set each of the fields with the registration form data.
            $newUser->setEmail($emailId);
            $newUser->setRole($accountType);
            $newUser->setUsername($username);
            $newUser->setPassword($password);
            $newUser->setStatus($status);
            $success = User::insert($newUser);

            // insert the data into the database.

            // if the insert is successful then message will be shown
            if ($success != null) {
                
                if($accountType == 'Student') {
                    $currentUser = User::getIdByEmail($emailId);
                    $insertResumeSampleData = new Resume();
                    $insertResumeSampleData->setId($currentUser->getId());
                    $insertResumeSampleData->setEmail($emailId);
                    $insertResumeSampleData->setStatus($status);
                    Resume::insert($insertResumeSampleData);
                }
                $templateName = 'redirect';
                $argsArray = array(
                    'headingMessage' => 'Welcome you are now registered.',
                    'otherMessage' => 'you can now login and create your curriculum vitae to look',
                    'otherMessage02' => 'for jobs in your area.'
                );
                
            }else {
                $templateName = 'register';
                $argsArray = array(
                   'errorMessage' => 'Sorry something went wrong !!'
                );
            }
            
        } else {
            $templateName = 'register';
            $argsArray = array(
                'errorMessage' => 'Sorry something went wrong !!'
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
        // args array title
        $argsArray = [
            'title' => 'Registration succeeded'
        ];

        // template for register
        $templateName = 'redirect';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

 
    /**
     * login action for the route /login
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function loginAction(Request $request, Application $app)
    {
        // logout any existing user
        $app['session']->set('user', null);

        // build args array
        // ------------
        $argsArray = [];

        // render (draw) template
        // ------------
        $templateName = 'login';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
    
    /**
     * logout action used for the root /logout
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function logoutAction(Request $request, Application $app)
    {
        // logout any existing user
        $app['session']->set('user', null);

        // redirect to home page
        //return $app->redirect('/');

        // render (draw) template
        // ------------
        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', []);
    }
}
