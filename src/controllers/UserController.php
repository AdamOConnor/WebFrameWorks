<?php
/**
 * @Author Adam O'Connor 
 * Webframeworks project.
 */
namespace Adamoconnorframeworks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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
        $roleNumber = User::canFindSpecificRoleOfUser($username);
        
        // if the user is logged in do this.
        if ($isLoggedIn) {
            
            // get the role number of the user that has logged in.
            switch ($roleNumber) {
                case 1:
                    $app['session']->set('user', array('username' => $username));
                    return $app->redirect('/student');
                case 2:
                    $app['session']->set('user', array('username' => $username));
                    return $app->redirect('/admin');
                case 3:
                    $app['session']->set('user', array('username' => $username));
                    return $app->redirect('/employer');
                default:
                    $message = 'We are sorry, but something went wrong.';
                    return error404($app, $message);
            }
        }
        
        // used if the login is wrong.
        else {
            $templateName = 'index';
            $argsArray = array(
                'errorMessage' => 'bad username or password - please re-enter'
            );

            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * Action used to process registration form
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
        $employmentStatus = $request->get('status');

        // instantiate the class needed 
        $newUser = new User();
        
        // set each of the fields with the registration form data.
        $newUser->setId($emailId);
        $newUser->setRole($accountType);
        $newUser->setUsername($username);
        $newUser->setPassword($password);
        $newUser->setEmployment($employmentStatus);

        // insert the data into the database.
        $success = User::insert($newUser);
        
        // if the insert is successful then message will be shown
        if($success != null) {
            $templateName = 'redirect';
            $argsArray = array(
                'errorMessage' => 'Thank you for registering you can now sign in.'
            );
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
        // otherwise show this message
        else {
            $templateName = 'register';
            $argsArray = array(
                'errorMessage' => 'Sorry something went wrong!! please try again.'
            );
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
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
        $template = 'redirect';
        return $app['twig']->render($template . '.html.twig', $argsArray);
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
