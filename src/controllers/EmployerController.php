<?php
/**
 * @Author Adam O'Connor
 * Employer controller for links etc.
 */
namespace Adamoconnorframeworks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * simple authentication using silex and twig template's
 * Class EmployerController
 * @package Adamoconnorframeworks\Controller
 */
class EmployerController
{
    
    /**
     * index action used for the employer index
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

        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Employer'
        );

        // get the correct template.
        $templateName = 'employer/index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * for the records action used for employer
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function recordsAction(Request $request, Application $app)
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
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Employer'
        );

        // template for the employer records
        $templateName = 'employer/codes';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}
