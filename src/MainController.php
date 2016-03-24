<?php
namespace Itb;
/**
 * Class MainController
 * @package Itb
 */

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MainController
{
    /**
     * @param \Twig_Environment   $twig
     */
    public function registerAction(Request $request, Application $app)
    {
        $argsArray = [
            'title' => 'Register',
        ];
        $template = 'register';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }

    /**
     * @param \Twig_Environment   $twig
     */
    public function contactAction(Request $request, Application $app)
    {
        $argsArray = [
            'title' => 'Contact',
        ];
        $template = 'contact';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }

    /**
     * @param \Twig_Environment   $twig
     */
    public function indexAction(Request $request, Application $app)
    {
        $argsArray = [
            'title' => 'Home',
        ];
        $template = 'index';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }
    
    /**
     * @param \Twig_Environment   $twig
     */
    public function sitemapAction(Request $request, Application $app)
    {
        $argsArray = [
            'title' => 'Site map',
        ];
        $template = 'sitemap';
        return $app['twig']->render($template . '.html.twig', $argsArray);
    }

    /**
     * @param Application $app
     * @param $message
     * @return mixed
     */
    public function error404(Application $app, $message)
    {
        $argsArray = [];
        $templateName = '404';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}