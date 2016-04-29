<?php

/**
 * used for all interactivity of the admin side of the login,
 * CRUD all student records within the pages on this side.
 */
namespace Adamoconnorframeworks\Controller;

use Adamoconnorframeworks\Model\Admin;
use Adamoconnorframeworks\Model\Pending;
use Adamoconnorframeworks\Model\PrivateMessage;
use Adamoconnorframeworks\Model\Resume;
use Adamoconnorframeworks\Model\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController
 * @package Adamoconnorframeworks\Controller
 */
class AdminController
{
    /**
     * allow access to admin/index
     * allows lecturer
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

        $userRepository = new User();
       // $getStudentRole = $userRepository->getUserByStudentRole('Student');
        $getAllDetails = $userRepository->getAll();

        // store username into args array
        // and rolename
        $argsArray = array(
            'users' => $getAllDetails,
            'username' => $username,
            'roleName' => 'Lecturer'
        );

        // template for admin index
        $templateName = 'admin/index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * action to go to employment details.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function employmentAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);
        // check for pending jobs from employers
        $pendingJobs = Pending::getAll();

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        // and rolename
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Lecturer',
            'jobs' => $pendingJobs
        );

        // template for admin index
        $templateName = 'admin/employment';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * action to go to employment details.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function pendingJobAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        $pendingJobs = Pending::getAll();

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        // and rolename
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Lecturer',
            'jobs' => $pendingJobs
        );

        // template for admin index
        $templateName = 'admin/pendingJobs';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
    
    /**
     * allow access to the codesAction
    * @param Request $request
    * @param Application $app
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
    public function registerAction(Request $request, Application $app)
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
        // and rolename
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Lecturer'
        );

        // template for admin codes.
        $templateName = 'admin/registerUser';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * view more information about user.
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function detailAction(Request $request, Application $app, $id)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $userRepository = new User();
        $user = $userRepository->getOneById($id);
        $cvRepository = new Resume();
        $usersCv = $cvRepository->getOneById($id);

        // store username into args array
        // and rolename
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Lecturer',
            'userDetails' => $user,
            'userCvDetails' => $usersCv
        );

        // template for admin codes.
        $templateName = 'admin/detail';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * delete user and resume details
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }
        $resumeRepository = Resume::deleteResume($id);
        $userRepository = User::delete($id);

        if ($resumeRepository && $userRepository) {
            return $app->redirect('/admin');
        } else {
            $templateName = 'messages';
            $argsArray = array(
                'username' => $username,
                'roleName' => $currentUser->getRole(),
                'otherMessage' => 'there was a problem delete message with id ' . $id . 'to the database ...'
            );
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * deletes the job from the pending_jobs table.
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteJobAction(Request $request, Application $app, $id)
    {
        // authenticated
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        // if user is not ther use admin.
        if ($currentUser == null) {
            $currentUser = Admin::getOneByUsername($username);
        }

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // delete the job
        $deleteJob = Pending::delete($id);

        if ($deleteJob == true) {
            $templateName = 'redirect';
            $argsArray = array(
                'headingMessage' => 'Success the job has been deleted !!',
                'otherMessage' => 'Job has now been deleted....',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );
        } else {
            $templateName = 'redirect';
            $argsArray = array(
                'headingMessage' => 'Sorry job has not been deleted !!',
                'otherMessage' => 'Something terrible has happend sorry....',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );
        }
       
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
    
    /**
     * edit resume details 
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editResumeAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);

        $resumeDetails = Resume::getOneById($id);
        $userDetails = User::getOneById($id);
        

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Lecturer',
            'resumeDetails' => $resumeDetails,
            'userDetails' => $userDetails
        );

        // template for student records
        $templateName = 'admin/updateCv';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * used to edit the login information of a user.
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editLoginAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $userDetails = User::getOneById($id);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => 'Lecturer',
            'userDetails' => $userDetails
        );

        // template for student records
        $templateName = 'admin/updateDetails';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * update single users login information.
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * 
     */
    public function updateLoginAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $emailId = $request->get('emailId');
        $user = $request->get('username');
        $password = $request->get('password');
        $rePassword = $request->get('repassword');
        $status = $request->get('status');
        $employmentStatus = $request->get('role');
        
        if ($password == $rePassword) {
            $updateUser = new User();
            // set each of the fields with the registration form data.
            $updateUser->setEmail($emailId);
            $updateUser->setUsername($user);
            $updateUser->setPassword($password);
            $updateUser->setStatus($status);
            $updateUser->setRole($employmentStatus);

            $updateResume = new Resume();
            $updateResume->setEmail($emailId);
            $updateResume->setStatus($status);

            $tryUpdateResume = Resume::updateUserCv($updateResume, $id);
            $tryUpdateUser = User::updateUserLogin($updateUser, $id);

            if ($tryUpdateResume != null || $tryUpdateUser != null) {
                $argsArray = array(
                    'username' => $username,
                    'roleName' => 'Lecturer',
                    'headingMessage' => 'The users login details have now been updated !!!',
                    'otherMessage' => 'Thank you for updating the users details.'
                );

                // template for student records
                $templateName = 'redirect';
            } else {
                $argsArray = array(
                    'username' => $username,
                    'roleName' => 'Lecturer',
                    'headingMessage' => 'Sorry something went wrong !!!',
                    'otherMessage' => 'Please try again.'
                );
                // template for student records
                $templateName = 'redirect';
            }
        } else {
            $argsArray = array(
                'username' => $username,
                'roleName' => 'Lecturer',
                'headingMessage' => 'Passwords dont match please try again',
                'otherMessage' => 'mismatch of passwords.'
            );

            // template for student records
            $templateName = 'redirect';
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * update a single user's cv 
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateCvAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
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
        $updateCv->setId($id);
        $updateCv->setEmail($email);
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

        if ($success) {
            $app['session']->set('user', array(
                'username' => $username,
                'roleName' => 'Lecturer'
            ));
            return $app->redirect('/redirectAdmin');
        } else {
            $app['session']->set('user', array(
                'username' => $username,
                'roleName' => 'Lecturer',
                'headingMessage' => 'Sorry something went wrong !!!',
                'otherMessage' => 'The cv that you where trying to update failed.'
            ));
            return $app->redirect('/redirectAdmin');
        }
    }

    /**
     * redirect for the lecturer
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        if ($currentUser == null) {
            $currentUser = Admin::getOneByUsername($username);
        }

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $argsArray = array(
            'username' => $username,
            'roleName' => $currentUser->getRole(),
            'headingMessage' => 'The cv has now been updated !!!',
            'otherMessage' => 'Thank you for updating submitting the cv.'
        );

        // template for student records
        $templateName = 'redirect';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * private message page
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function privateMessageAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $sending = Admin::getOneByUsername($username);

        if ($sending == null) {
            $sending = User::getOneByUsername($username);
        }

        $receiver = Admin::getOneByUsername($id);

        if ($receiver == null) {
            $receiver = User::getOneByUsername($id);
        }
        if ($receiver == null) {
            $receiver = User::getOneById($id);
        }

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $argsArray = array(
            'username' => $username,
            'roleName' => $sending->getRole(),
            'receivingUser' => $receiver,
            'sendingUser' => $sending,
        );

        // template for student records
        $templateName = 'admin/privateMessage';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * for admin to create a public message.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createMessageAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);
        $currentUser = Admin::getOneByUsername($username);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => $currentUser->getRole()
        );

        // template used for student index
        $templateName = 'admin/createMessage';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * process a registration form for a admin.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function processRegistrationFormAdminAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $AdminUser = Admin::getOneByUsername($username);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // get text from each field on the registration form
        $accountType = $request->get('account');
        $emailId = $request->get('email');
        $username = $request->get('username');
        $password = $request->get('password');
        $rePassword = $request->get('rePassword');
        $status = $request->get('status');

        if ($password != $rePassword || $rePassword != $password) {
            $templateName = 'admin/registerUser';
            $argsArray = array(
                'username' => $AdminUser->getUsername(),
                'roleName' => $AdminUser->getRole(),
                'errorMessage' => 'Sorry the passwords do not match !!'
            );
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }

        $checkDetails = User::checkRegistration($emailId, $username);

        if ($checkDetails == null) {
            // instantiate the class needed
            if ($accountType == 'Lecturer') {
                $newAdmin = new Admin();
                $newAdmin->setEmail($emailId);
                $newAdmin->setRole($accountType);
                $newAdmin->setUsername($username);
                $newAdmin->setPassword($password);
                $success = Admin::insert($newAdmin);

                $to = $emailId;
                $subject = "Registration completed";
                $txt = "Congratulations you have now been registered on the CDM Work Placement website ";
                $headers = "From: B00066540@student.itb.ie" . "\r\n";
                mail($to, $subject, $txt, $headers);
            } else {
                $newUser = new User();
                $newUser->setEmail($emailId);
                $newUser->setRole($accountType);
                $newUser->setUsername($username);
                $newUser->setPassword($password);
                $newUser->setStatus($status);
                $success = User::insert($newUser);

                $to = $emailId;
                $subject = "Registration completed";
                $txt = "Congratulations you have now been registered on the CDM Work Placement website ";
                $headers = "From: B00066540@student.itb.ie" . "\r\n";
                mail($to, $subject, $txt, $headers);
            }

            if ($success) {
                if ($accountType == 'Student') {
                    $currentUser = User::getIdByEmail($emailId);
                    $insertResumeSampleData = new Resume();
                    $insertResumeSampleData->setId($currentUser->getId());
                    $insertResumeSampleData->setEmail($emailId);
                    $insertResumeSampleData->setStatus($status);
                    Resume::insert($insertResumeSampleData);
                }
                $templateName = 'redirect';
                $argsArray = array(
                    'username' => $AdminUser->getUsername(),
                    'roleName' =>  $AdminUser->getRole(),
                    'headingMessage' => 'Well done you now registered a user.',
                    'otherMessage' => 'users can now login and create your curriculum vitae to look',
                );
            } else {
                $templateName = 'admin/registerUser';
                $argsArray = array(
                    'username' => $AdminUser->getUsername(),
                    'roleName' =>  $AdminUser->getRole(),
                    'errorMessage' => 'Sorry please choose a different email and username !!'
                );
            }
        } else {
            $templateName = 'admin/registerUser';
            $argsArray = array(
                'username' => $AdminUser->getUsername(),
                'roleName' =>  $AdminUser->getRole(),
                'errorMessage' => 'Please choose different username and email.'
            );
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * show private messages to the admin.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function showPrivateMessagesAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);
        $currentUser = Admin::getOneByUsername($username);
        $messages = PrivateMessage::getAll();
        $student = User::getAll();
        $admin = Admin::getOneByUsername($username);

        if ($currentUser == null) {
            $currentUser = User::getOneByUsername($username);
        }

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        $argsArray = array(
            'username' => $username,
            'roleName' => $currentUser->getRole(),
            'messages' => $messages,
            'students' => $student,
            'admin' => $admin
        );

        // template used for student index
        $templateName = 'admin/listPrivate';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * used by admin to set the status of a pending job to active.
     * so that students can view it.
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function jobStatusAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = Admin::getOneByUsername($username);
        

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }
        
        $status = 'Active';
        
        $pending = Pending::updateStatus($status, $id);
        
        if ($pending != null) {
            $templateName = 'redirect';
            $argsArray = array(
                'headingMessage' => 'Success the job has been added !!',
                'otherMessage' => 'Job has now been added and students can now view....',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );
        } else {
            $templateName = 'redirect';
            $argsArray = array(
                'headingMessage' => 'Sorry job has not been added !!',
                'otherMessage' => 'Something terrible has happend sorry....',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}
