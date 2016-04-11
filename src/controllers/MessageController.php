<?php
namespace Adamoconnorframeworks\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Adamoconnorframeworks\Model\User;
use Adamoconnorframeworks\Model\Message;
use Mattsmithdev\PdoCrud\DatabaseTable;

class MessageController
{
    public function messagesAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $messageRepository = new Message();
        $getAllMessages = $messageRepository->getAll();

        //$messages = $messageRepository->getAll();
        if($messageRepository != null) {
            $templateName = 'messages';
            $argsArray = array(
                'messages' => $getAllMessages,
                'username' => $username,
                'roleName' => $currentUser->getRole(),
                'emailId' => $currentUser->getEmail()
            );
        }else {
            $templateName = 'messages';
            $argsArray = [
                'otherMessage' => 'There are currently no messages.',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            ];
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function submitAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

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
        
        if($messageRepository != null){
            
            $dvdRepository = new Message();
            $messageRepository = $dvdRepository->getAll();
            $templateName = 'messages';
            
            $argsArray = array(
                'messages' => $messageRepository,
                'username' => $username,
                'roleName' => $currentUser->getRole(),
                'emailId' => $currentUser->getEmail()
            );

        } else {
            $templateName = 'messages';
            $argsArray = array(
                'otherMessage' => 'Sorry a Problem has occured.',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );

        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
    
    public function deleteAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $messageRepository = Message::delete($id);

        if($messageRepository != null){

            $dvdRepository = new Message();
            $messageRepository = $dvdRepository->getAll();
            $templateName = 'messages';

            if($messageRepository > 0) {

                $argsArray = array(
                    'messages' => $messageRepository,
                    'username' => $username,
                    'roleName' => $currentUser->getRole()
                );
            }
            else {
                $argsArray = array(
                    'otherMessage' => 'Sorry there was a problem.'
                );
            }

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

    public function messageEditAction(Request $request, Application $app, $id)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
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

    public function updateAction(Request $request, Application $app)
    {
        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }
        
        // now sanitise with filter_var()
        $id = $request->get('id');
        $text = $request->get('text');
        $user = $request->get('user');

        // get Unix timestamp for the current time
        $now = new \DateTime();
        $timestamp = $now->getTimestamp();

        // create message object
        $message = new Message();
        $message->setText($text);
        $message->setUser($user);
        $message->setTimestamp($timestamp);

        // use MessageRepository to store new Message object
//        $messageRepository = new MessageRepository();
        $messageRepository = Message::update($message);
        if($messageRepository != null){
            $templateName = 'messages';
            $argsArray = array(
                'otherMessage' => 'Thank you your message has been sent.',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );
        } else {
            $templateName = 'messages';
            $argsArray = array(
                'otherMessage' => 'there was a problem delete message with id ' . $id . 'to the database ...',
                'username' => $username,
                'roleName' => $currentUser->getRole()
            );
        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }


}