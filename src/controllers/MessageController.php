<?php
/**
 *  summary for messages action class
 *  to preform all messages functions
 */
namespace Adamoconnorframeworks\Controller;

use Adamoconnorframeworks\Model\Admin;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Adamoconnorframeworks\Model\User;
use Adamoconnorframeworks\Model\Message;
use Adamoconnorframeworks\Model\PrivateMessage;

/**
 * Class MessageController
 * @package Adamoconnorframeworks\Controller
 */

class MessageController
{
    /**
     * messages action to show normal public messages,
     * to all users.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function messagesAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);
        $adminUser = Admin::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $messageRepository = new Message();
        $getAllMessages = $messageRepository->getAll();

        if ($messageRepository != null) {
            $templateName = 'messages';
            if ($currentUser) {
                $argsArray = [
                    'messages' => $getAllMessages,
                    'username' => $username,
                    'roleName' => $currentUser->getRole(),
                    'emailId' => $currentUser->getEmail()
                ];
            } elseif ($adminUser) {
                $argsArray = array(
                    'messages' => $getAllMessages,
                    'username' => $username,
                    'roleName' => $adminUser->getRole(),
                    'emailId' => $adminUser->getEmail()
                );
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $templateName = 'messages';
            $argsArray = [
                'otherMessage' => 'There are currently no messages.',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            ];
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * show messages to the admin displayed,
     * differently can delete all.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminMessagesAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        if ($currentUser == null) {
            $adminUser = Admin::getOneByUsername($username);
        }


        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $messageRepository = new Message();
        $getAllMessages = $messageRepository->getAll();
        
        if ($messageRepository != null) {
            if ($currentUser) {
                $templateName = 'admin\messages';
                $argsArray = array(
                    'messages' => $getAllMessages,
                    'username' => $username,
                    'roleName' => $currentUser->getRole(),
                    'emailId' => $currentUser->getEmail()
                );
            } elseif ($adminUser) {
                $templateName = 'admin\messages';
                $argsArray = array(
                    'messages' => $getAllMessages,
                    'username' => $username,
                    'roleName' => $adminUser->getRole(),
                    'emailId' => $adminUser->getEmail()
                );
            }
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        } else {
            $templateName = 'admin\messages';
            $argsArray = array(
                'otherMessage' => 'There are currently no messages.',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * submit a message that can be seen by everyone.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function submitAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        if ($currentUser == null) {
            $currentUser = Admin::getOneByUsername($username);
        }

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }
        
        // now sanitise with filter_var()
        $text = $request->get('text');
        $user = $request->get('usernameId');

        // get Unix timestamp for the current time
        $now = new \DateTime();
        $timestamp = $now->getTimestamp();

        // create message object
        $message = new Message();
        $message->setText($text);
        $message->setEmail($currentUser->getEmail());
        $message->setUser($user);
        $message->setTimestamp($timestamp);

        $messageRepository = Message::insert($message);
        
        if ($messageRepository) {
            return $app->redirect('/messages');
        } else {
            $templateName = 'messages';
            $argsArray = array(
                'otherMessage' => 'Sorry a Problem has occured.',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * delete a message action.
     * deletes a message from the database using the id.
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
            return $app->redirect('/login');
        }

        $messageRepository = Message::delete($id);

        if ($messageRepository) {
            if ($currentUser == null) {
                return $app->redirect('/adminMessages');
            } else {
                return $app->redirect('/messages');
            }
        } else {
            if ($currentUser == null) {
                $templateName = 'admin/privateMessage';
                $argsArray = array(
                    'username' => $username,
                    'roleName' => 'Lecturer',
                    'otherMessage' => 'there was a problem with deleting the message...'
                );
            } else {
                $templateName = 'messages';
                $argsArray = array(
                    'username' => $username,
                    'roleName' => $currentUser->getRole(),
                    'otherMessage' => 'there was a problem with deleting the message...'
                );
            }
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * deleting private message action,
     * deletes private messages from the table.
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function privateDeleteAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $messageRepository = PrivateMessage::delete($id);

        if ($messageRepository == true) {
            if ($currentUser == null) {
                return $app->redirect('/showPrivate');
            } else {
                return $app->redirect('/messages');
            }
        } else {
            if ($currentUser == null) {
                $templateName = 'admin/privateMessage';
                $argsArray = array(
                    'username' => $username,
                    'roleName' => 'Lecturer',
                    'otherMessage' => 'there was a problem with deleting the message...'
                );
            } else {
                $templateName = 'messages';
                $argsArray = array(
                    'username' => $username,
                    'roleName' => $currentUser->getRole(),
                    'otherMessage' => 'there was a problem with deleting the message...'
                );
            }
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * edit any message on the table that user has privilege to.
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function messageEditAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }
        
        if ($currentUser == null) {
            $currentUser = Admin::getOneByUsername($username);
        }

        $message = Message::getOneById($id);

        $argsArray = [
            'message' => $message,
            'username' => $username,
            'roleName' => $currentUser->getRole()
        ];

        $templateName = 'messageEdit';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * edit a private message that the user has access to.
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function privateMessageEditAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        if ($currentUser == null) {
            $currentUser = Admin::getOneByUsername($username);
        }

        $message = PrivateMessage::getOneById($id);

        $argsArray = [
            'message' => $message,
            'username' => $username,
            'roleName' => $currentUser->getRole(),
            'id' => $id
        ];

        $templateName = 'admin/privateMessageEdit';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * update a message action.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        if ($currentUser == null) {
            $currentUser = Admin::getOneByUsername($username);
        }
        
        // now sanitise with filter_var()
        $id = $request->get('id');
        $text = $request->get('text');

        // get Unix timestamp for the current time
        $now = new \DateTime();
        $timestamp = $now->getTimestamp();

        // create message object
        $message = new Message();
        $message->setId($id);
        $message->setUser($username);
        $message->setEmail($currentUser->getEmail());
        $message->setText($text);
        $message->setTimestamp($timestamp);
        
        $messageRepository = Message::update($message);
        
        if ($messageRepository != null) {
            if ($currentUser->getRole() == 'Student') {
                return $app->redirect('/messages');
            } else {
                return $app->redirect('/adminMessages');
            }
        } else {
            $templateName = 'messages';
            $argsArray = array(
                'otherMessage' => 'there was a problem with updating the message ' . $id . 'to the database ...',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * private update message action.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function privateUpdateAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        if ($currentUser == null) {
            $currentUser = Admin::getOneByUsername($username);
        }

        // now sanitise with filter_var()
        $text = $request->get('text');
        $about = $request->get('aboutCvMessage');
        $id = $request->get('id');

        // get Unix timestamp for the current time
        $now = new \DateTime();
        $timestamp = $now->getTimestamp();

        // create message object
        $message = new PrivateMessage();
        $message->setAbout($about);
        $message->setText($text);
        $message->setTimestamp($timestamp);

        $messageRepository = PrivateMessage::update($message, $id);

        if ($messageRepository != null) {
            if ($currentUser->getRole() == 'Student') {
                return $app->redirect('/privateMessages');
            } else {
                return $app->redirect('/showPrivate');
            }
        } else {
            $templateName = 'messages';
            $argsArray = array(
                'otherMessage' => 'there was a problem with updating the message to the database ...',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * send private message
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function privateMessageAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        if ($currentUser == null) {
            $currentUser = Admin::getOneByUsername($username);
        }

        // now sanitise with filter_var()
        $text = $request->get('text');
        $sender = $request->get('senderId');
        $receiver = $request->get('receivingId');
        $about = $request->get('aboutCvMessage');

        // get Unix timestamp for the current time
        $now = new \DateTime();
        $timestamp = $now->getTimestamp();

        // create message object
        $private = new PrivateMessage();
        $private->setSender($sender);
        $private->setReceiver($receiver);
        $private->setText($text);
        $private->setAbout($about);
        $private->setTimestamp($timestamp);
        
        $messageRepository = PrivateMessage::insert($private);

        if ($messageRepository == true) {
            return $app->redirect('/adminMessages');
        } else {
            $templateName = 'messages';
            $argsArray = array(
                'otherMessage' => 'Sorry a Problem has occured.',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * create a private message from admin side shows all user's.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAdminPrivateMessageAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $sending = Admin::getOneByUsername($username);
        $receiver = User::getAll();


        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $argsArray = array(
            'username' => $username,
            'roleName' => $sending->getRole(),
            'receivers' => $receiver,
            'sendingUser' => $sending
        );

        // template for student records
        $templateName = 'admin/createPrivateMessage';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * create private message student side sends messages to lecture's.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createStudentPrivateMessageAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $sending = User::getOneByUsername($username);
        $receiver = Admin::getAll();


        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $argsArray = array(
            'username' => $username,
            'roleName' => $sending->getRole(),
            'receivers' => $receiver,
            'sendingUser' => $sending
        );

        // template for student records
        $templateName = 'admin/createPrivateMessage';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * create employer message side, can send messages to students, or lectures.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createEmployerPrivateMessageAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $sending = User::getOneByUsername($username);
        $receiver = Admin::getAll();
        $users = User::getAll();


        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $argsArray = array(
            'username' => $username,
            'roleName' => $sending->getRole(),
            'receivers' => $receiver,
            'users' => $users,
            'sendingUser' => $sending
        );

        // template for student records
        $templateName = 'employer/create';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}
