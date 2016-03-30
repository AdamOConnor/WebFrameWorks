<?php
/**
 * Created by PhpStorm.
 * User: Adam O'Connor
 * Date: 14/03/2016
 * Time: 10:01
 */

use Silex\Application;

/**
     * add namespace to the string, after exploding controller name from action
     *
     * examples:
     * input:   Adamoconnorframeworks, main/index
     * output:  Itb\MainController::indexAction
     *
     * input:   Mattsmithdev\Samples, hello/name
     * output:  Mattsmithdev\Samples\HelloController::nameAction
     *
     * @param $shortName controller and action name sepaerate by "/"
     * @return string namespace, controller class name plus :: plus action name
     */
    function controller($namespace, $shortName)
    {
        list($shortClass, $shortMethod) = explode('/', $shortName, 2);

        $shortClassCapitlise = ucfirst($shortClass);

        $namespaceClassAction = sprintf($namespace . '\\' . $shortClassCapitlise . 'Controller::' . $shortMethod . 'Action');

        return $namespaceClassAction;
    }

    /**
    * if user logged-in, THEN return user's username
     * if user not logged-in THEN return 'null'
     *
     * @param Application $app
     * @return null (or string username)
     */
    function getAuthenticatedUserName(Application $app)
    {
        // IF 'user' found with non-null value in 'session'
        $user = $app['session']->get('user');
    
        if (null != $user) {
            // THEN return username inside 'user' array
            return $user['username'];
        } else {
            // ELSE return 'null' (i.e. no user logged in at present)
            return null;
        }
    }

    /**
     * @param Application $app
     * @param $message
     * @return mixed
     */
    function error404(Application $app, $message)
    {
        $argsArray = [];
        $templateName = '404';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
