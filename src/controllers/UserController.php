<?php

namespace Adamoconnorframeworks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

//use Hdip\Model\DvdRepository;

/**
 * Class UserController
 *
 * simple authentication using Silex session object
 * $app['session']->set('isAuthenticated', false);
 *
 * but the propert way to do it:
 * https://gist.github.com/brtriver/1740012
 *
 * @package Hdip\Controller
 */
class UserController
{
    // action for POST route:    /processLogin
    public function processLoginAction(Request $request, Application $app)
    {
        // retrieve 'name' from GET params in Request object
        $username = $request->get('username');
        $password = $request->get('password');

        $isLoggedIn = User::canFindMatchingUsernameAndPassword($username , $password);

        if($isLoggedIn) {
            $app['session']->set('user', array('username' => $username) );
            return $app->redirect('/admin');
        }

        // authenticate!
        //if ('user' === $username && 'user' === $password) {
            // store username in 'user' in 'session'
          //  $app['session']->set('user', array('username' => $username) );

            // success - redirect to the secure admin home page
         //   return $app->redirect('/admin');
        //}

        // login page with error message
        // ------------
        else {
            $templateName = 'index';
            $argsArray = array(
                'errorMessage' => 'bad username or password - please re-enter'
            );

            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    // action for route:    /login
    public function loginAction(Request $request, Application $app)
    {
        // logout any existing user
        $app['session']->set('user', null );

        // build args array
        // ------------
        $argsArray = [];

        // render (draw) template
        // ------------
        $templateName = 'login';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    // action for route:    /logout
    public function logoutAction(Request $request, Application $app)
    {
        // logout any existing user
        $app['session']->set('user', null );

        // redirect to home page
//        return $app->redirect('/');

        // render (draw) template
        // ------------
        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', []);

    }


}