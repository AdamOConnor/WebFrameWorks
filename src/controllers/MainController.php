<?php

/**
 * main routing for the index page '/'
 * normal user's
 */
namespace Adamoconnorframeworks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Adamoconnorframeworks\Model\User;
use Adamoconnorframeworks\Model\Admin;

/**
 * Class MainController
 * @package Adamoconnorframeworks\Controller
 */

class MainController
{

    /**
     * registrationAction for register
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function registerAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        
        // args array title
        $argsArray = [
            'title' => 'Register',
            'username' => $username
        ];

        // template for register
        $template = 'register';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }

    /**
     * contact action
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function contactAction(Request $request, Application $app)
    {
        //authentication for user
        $username = getAuthenticatedUserName($app);

        // args array
        $argsArray = [
            'title' => 'Contact',
            'username' => $username
        ];
        // template for contact
        $template = 'contact';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }

    /**
     * index request action
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function indexAction(Request $request, Application $app)
    {
        //authentication for user index
        $username = getAuthenticatedUserName($app);
        $getUserRole = User::canFindSpecificRoleOfUser($username);
        $getAdminRole = Admin::canFindSpecificRoleOfUser($username);

        if ($getUserRole) {
            switch ($getUserRole) {
                case 'Student':
                    $app['session']->set('user', array('username' => $username));
                    return $app->redirect('/student');
                case 'Employer':
                    $app['session']->set('user', array('username' => $username));
                    return $app->redirect('/employer');
            }
        } elseif ($getAdminRole == 'Lecturer') {
            $app['session']->set('user', array('username' => $username));
            return $app->redirect('/admin');
        }
        // args array for title and username
                $argsArray = [
                    'title' => 'Home',
                    'username' => $username
                ];
        
        // template for index page
        $template = 'index';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }

    /**
     * sitemap action
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function sitemapAction(Request $request, Application $app)
    {
        // authentication for sitemap
        $username = getAuthenticatedUserName($app);
        $argsArray = [
            'title' => 'Site map',
            'username' => $username
        ];

        // template for the sitemap
        $template = 'sitemap';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }

    /**
     * routing to the error template of user goes of course.
     * @param Application $app
     * @return mixed
     */
    public static function error404(Application $app)
    {
        $argsArray = [
            'errorMessage' => 'Sorry we couldnt find this page...',
            'errorHeading' => 'No page found.'
        ];
        $templateName = '404';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}
