<?php
/**
 * @Author Adam O'Connor
 * Class Student Controller
 */
namespace Adamoconnorframeworks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * simple authentication getting specific links
 * Class StudentController
 * @package Adamoconnorframeworks\Controller
 */
class StudentController
{

    /**
     * index action for the student login.
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
            'roleName' => 'Student'
        );

        // template used for student index
        $templateName = 'student/index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * records action for student,
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function cvAction(Request $request, Application $app)
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
            'roleName' => 'Student'
        );

        // template for student records
        $templateName = 'student/cvForm';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}
