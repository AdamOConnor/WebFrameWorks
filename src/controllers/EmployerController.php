<?php
/**
 * @Author Adam O'Connor
 * Employer controller for links etc.
 */
namespace Adamoconnorframeworks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Adamoconnorframeworks\Model\Pending;
use Adamoconnorframeworks\Model\User;

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
        $date = '07.03.2011';
        date_default_timezone_set('Europe/Dublin');
        $x = strtotime("$date 18:11");
        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Employer',
            'time' => $x
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

    public function processJobAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $jobDescription = $request->get('description');
        $position = $request->get('position');
        $company = $request->get('company');
        $date = $request->get('date');
        $time = $request->get('time');
        $status = 'Pending';

        date_default_timezone_set('Europe/Dublin');
        $timeStamp = strtotime("$date $time");

        $pending = new Pending();
        $pending->setStatus($status);
        $pending->setUsername($username);
        $pending->setDescription($jobDescription);
        $pending->setPosition($position);
        $pending->setCompany($company);
        $pending->setTimestamp($timeStamp);

        $pendingJobs = Pending::insert($pending);

        if ($pendingJobs != null) {
            $templateName = 'redirect';
            $argsArray = array(
                'headingMessage' => 'Success the job has been sent !!',
                'otherMessage' => 'The lecturers have been sent this job thanks....',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );

        } else {
            $templateName = 'redirect';
            $argsArray = array(
                'headingMessage' => 'Sorry something went wrong !!! ',
                'otherMessage' => 'Sorry please try again something bad happened...',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );

        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

}
