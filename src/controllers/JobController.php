<?php
/**
 * Created by PhpStorm.
 * User: Adam O'Connor
 * Date: 19/04/2016
 * Time: 00:41
 */

namespace Adamoconnorframeworks\Controller;

use Adamoconnorframeworks\Model\Resume;
use Adamoconnorframeworks\Model\User;
use Adamoconnorframeworks\Model\JobApplications;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class JobController
 * @package Adamoconnorframeworks\Controller
 */
class JobController
{

    /**
     * used to apply for a job that the employer has distributed.
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return mixed
     */
    public function applyAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);

        $currentUser = User::getOneByUsername($username);
        $studentApplication = Resume::getOneById($currentUser->getId());

        $name = $studentApplication->getName();
        $surname = $studentApplication->getSurname();
        $email = $studentApplication->getEmail();
        $number = $studentApplication->getNumber();
        $image = $studentApplication->getImage();
        $status = $studentApplication->getStatus();
        $address = $studentApplication->getAddress();
        $town = $studentApplication->getTown();
        $city = $studentApplication->getCity();
        $eircode = $studentApplication->getEircode();
        $country = $studentApplication->getCountry();
        $previousEmployment = $studentApplication->getEmployment();
        $qualifications = $studentApplication->getQualifications();
        $skills = $studentApplication->getSkills();

        $jobApplication = new JobApplications();
        $jobApplication->setJob($id);
        $jobApplication->setName($name);
        $jobApplication->setSurname($surname);
        $jobApplication->setEmail($email);
        $jobApplication->setNumber($number);
        $jobApplication->setImage($image);
        $jobApplication->setStatus($status);
        $jobApplication->setAddress($address);
        $jobApplication->setTown($town);
        $jobApplication->setCity($city);
        $jobApplication->setEircode($eircode);
        $jobApplication->setCountry($country);
        $jobApplication->setEmployment($previousEmployment);
        $jobApplication->setQualifications($qualifications);
        $jobApplication->setSkills($skills);

        $success = JobApplications::insert($jobApplication);


        $templateName = 'redirect';

        $argsArray = array(
            'username' => $username,
            'roleName' => $currentUser->getRole(),
            'headingMessage' => 'Your cv has been submitted !!!',
            'otherMessage' => 'Thank you for submitting your cv'
        );

        if (!$success) {
            $argsArray = array(
                'username' => $username,
                'roleName' => $currentUser->getRole(),
                'headingMessage' => 'Sorry Could not complete !!!',
                'otherMessage' => 'sorry something went wrong....'
            );
        }
        // template for student records

        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}
