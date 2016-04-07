<?php
/**
 * @Author Adam O'Connor
 * Class Student Controller
 */
namespace Adamoconnorframeworks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Adamoconnorframeworks\Model\User;
use Adamoconnorframeworks\Model\Resume;

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
        $currentUser = User::getOneByUsername($username);
        $user = $currentUser->getId();
        $sampleData = Resume::getOneByUsername($user);
       // $sampleData = Resume::getOneByEmail('adam-o-connor@hotmail.com');
        //$test = $sampleData->getName();

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

       // echo 'here we rea\z'.$user;

        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Student',
            'name' => $sampleData->getName(),
            'surname' => $sampleData->getSurname(), 
            'currentEmail' => $sampleData->getId(),
            'myNumber' => $sampleData->getNumber(),
            'image' => $sampleData->getImage(),
            'status' => $sampleData->getStatus(),
            'address' => $sampleData->getAddress(),
            'town' => $sampleData->getTown(),
            'city' => $sampleData->getCity(),
            'eircode' => $sampleData->getEircode(),
            'country' => $sampleData->getCountry(),
            'employment' => $sampleData->getEmployment(),
            'skills' => $sampleData->getSkills(),
            'qualifications' => $sampleData->getQualifications()
           // 'emlploymentDetails' => $sampleData->getPreviousEmployment()
        );

        // template for student records
        $templateName = 'student/cvForm';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * this is the action used for processing
     * the resume form.
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processResumeAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);
        $user = $currentUser->getId();
        $sampleData = Resume::getOneByUsername($user);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $email = $request->get('emailAddress');
        $firstName = $request->get('firstname');
        $surname = $request->get('surname');
        $number = $request->get('number');
        $image = $request->get('image');
        $employmentStatus = $request->get('status');
        $addressLine01 = $request->get('addressLine01');
        $addressLine02 = $request->get('addressLine02');
        $city = $request->get('city');
        $eircode = $request->get('eircode');
        $country = $request->get('country');
        $employment = $request->get('employment');
        $qualifications = $request->get('qualifications');
        $skills = $request->get('skills');

        $updateCv = new Resume();

        // set each of the fields with the registration form data.
        $updateCv->setId($email);
        $updateCv->setName($firstName);
        $updateCv->setSurname($surname);
        $updateCv->setNumber($number);
        $updateCv->setImage($image);
        $updateCv->setStatus($employmentStatus);
        $updateCv->setAddress($addressLine01);
        $updateCv->setTown($addressLine02);
        $updateCv->setCity($city);
        $updateCv->setEircode($eircode);
        $updateCv->setCountry($country);
        $updateCv->setEmployment($employment);
        $updateCv->setQualifications($qualifications);
        $updateCv->setSkills($skills);

        $success = Resume::update($updateCv);
     
        if ($success != null) {
            $templateName = 'redirect';
            $argsArray = array(
                'headingMessage' => 'Your cv has now been updated !!! ',
                'otherMessage' => 'Thank you for submitting your cv.',
                'username' => $username,
                'roleName' => 'Student'
            );
        } // otherwise show this message
        else {
            $templateName = 'redirect';
            $argsArray = array(
                'headingMessage' => 'Woops !!!',
                'otherMessage' => 'Sorry something went wrong!! please try again.',
                'username' => $username,
                'roleName' => 'Student',
            );
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * redirect the user if the form has
     * succeeded to process and is saved
     * in the database.
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function redirectAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $argsArray = array(
            'headingMessage' => 'Your cv has now been updated !!!',
            'otherMessage' => 'Thank you for submitting your cv.'
        );

        // template for student records
        $templateName = 'student/redirect';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}
