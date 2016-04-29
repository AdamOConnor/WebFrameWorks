<?php
/**
 * summary of error controller to sort 404 errors
 */
namespace Adamoconnorframeworks\Controller;

use Silex\Application;

/**
 * Class ErrorController
 * @package Adamoconnorframeworks\Controller
 */

class ErrorController
{
    /**
     * error action when wrong pages requested.
     * @param Application $app
     * @param $code
     * @return mixed
     */
    public function errorAction(Application $app, $code)
    {
        $argsArray = [];
        $templateName = '404';
        
        if (404 == $code) {
            $argsArray = [
                'header' => 'no such page/resource - 404',
                'message' => 'sorry - we cant find what you have requested...'
            ];
            $templateName = 'error';
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}
