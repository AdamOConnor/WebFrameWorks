<?php

namespace Adamoconnorframeworks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MainController
{

    public function registerAction(Request $request, Application $app)
    {
        
        $argsArray = [
            'title' => 'Register'
        ];
        $template = 'register';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }

    /**
     * @param \Twig_Environment   $twig
     */
    public function contactAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        
        $argsArray = [
            'title' => 'Contact',
            'username' => $username
        ];
        $template = 'contact';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }

    /**
     * @param \Twig_Environment   $twig
     */
    public function indexAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        
        $argsArray = [
            'title' => 'Home',
            'username' => $username
        ];
        $template = 'index';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }
    
    /**
     * @param \Twig_Environment   $twig
     */
    public function sitemapAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $argsArray = [
            'title' => 'Site map',
            'username' => $username
        ];
        $template = 'sitemap';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }
    
}