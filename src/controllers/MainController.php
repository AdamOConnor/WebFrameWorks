<?php

/**
 * @Author Adam O'Connor
 * maincontroller for common users
 */
namespace Adamoconnorframeworks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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
        // args array title
        $argsArray = [
            'title' => 'Register'
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
}
