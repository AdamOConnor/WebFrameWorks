<?php
namespace Adamoconnorframeworks\Model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

/**
 * Class PrivateMessage
 * @package Adamoconnorframeworks\Model
 */
class PrivateMessage extends DatabaseTable
{
    /**
     * id of the private message.
     * @var int
     */
    private $id;
    
    /**
     * sender user's name.
     * @var string
     */
    private $sendingUser;

    /**
     *receiving users name.
     * @var string
     */
    private $receivingUser;

    /**
     * about what part of the cv.
     * @var string
     */
    private $about;

    /**
     * the text that is sent.
     * @var String
     */
    private $text;

    /**
     * PHP timestamp of when text created
     * @var \DateTime
     */
    private $timestamp;
    
    /**
     * get the id of the message.
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set the id of the private message.
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * get the sending user's username.
     * @return string
     */
    public function getSendingUser()
    {
        return $this->sendingUser;
    }

    /**
     * set the sending user's username.
     * @param $sendingUser
     */
    public function setSendingUser($sendingUser)
    {
        $this->sendingUser = $sendingUser;
    }

    /**
     * get the receiving users username.
     * @return string
     */
    public function getReceivingUser()
    {
        return $this->receivingUser;
    }

    /**
     * set the receiving username of the 
     * private message.
     * @param $receivingUser
     */
    public function setReceivingUser($receivingUser)
    {
        $this->receivingUser = $receivingUser;
    }

    /**
     * get the message details 
     * for what the message is about.
     * @return mixed
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * set what the message is about.
     * @param mixed $about
     */
    public function setAbout($about)
    {
        $this->about = $about;
    }

    /**
     * get the text that the message 
     * has incorporated.
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * set the text that is in the message.
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * set the timestamp of the private message.
     * @param $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * get the timestamp from the private message.
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * get all of the private message's
     * from the private message table.
     * @return array
     */
    public static function getAll()
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM private_messages';
        $statement = $connection->prepare($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        $objects = $statement->fetchAll();
        return $objects;
    }

    /**
     * update the private message from the 
     * specific user.
     * @param PrivateMessage $message
     * @param $id
     * @return null|string
     */
    public static function update(PrivateMessage $message, $id)
    {
        $text = $message->getText();
        $about = $message->getAbout();
        $time = $message->getTimestamp();
        
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'UPDATE private_messages SET text=:text, about=:about, timestamp=:myTime WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->bindParam(':text', $text, \PDO::PARAM_STR);
        $statement->bindParam(':about', $about, \PDO::PARAM_STR);
        $statement->bindParam(':myTime', $time, \PDO::PARAM_INT);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        if($queryWasSuccessful) {
            return $connection->lastInsertId();
        } else {
            return null;
        }
    }

    /**
     * get the private message from the 
     * id that is sent in.
     * @param $id
     * @return mixed|null
     */
    public static function getOneById($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM private_messages WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }

    /**
     * delete the private message from,
     * the private messages table.
     * @param $id
     * @return bool
     */
    public static function delete($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $statement = $connection->prepare('DELETE from private_messages WHERE id=:id');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryWasSuccessful = $statement->execute();
        return $queryWasSuccessful;
    }

    /**
     * insert the private message into the private 
     * message table.
     * @param PrivateMessage $message
     * @return null|string
     */
    public static function insert(PrivateMessage $message)
    {
        $sendingUser = $message->getSendingUser();
        $receivingUser = $message->getReceivingUser();
        //$senderId = $message->getSendingId();
        //$receiverId = $message->getReceivingId();
        $details = $message->getAbout();
        $text = $message->getText();
        $myTime = $message->getTimestamp();

        $db = new DatabaseManager();
        $connection = $db->getDbh();

        // INSERT INTO users (firstname, surname, id, mynumber, image, addressline01, addressline02, city, eircode, country, previousemployment, qualifications, skills)
        //VALUES (:firstname, :surname, :id, :mynumber, :image, addressline01, addressline02, :city, :eircode, :country, :previousemployment, :qualifications, :skills)
        $statement = $connection->prepare('INSERT into private_messages (sender_username, receiver_username, text, about, timestamp)
        VALUES (:sender_username, :receiver_username, :text, :about, :stamp)');
        //$statement = $connection->prepare('INSERT into resume (firstname) VALUES (:firstname)');
       // $statement->bindParam(':sender', $senderId, \PDO::PARAM_INT);
        $statement->bindParam(':sender_username', $sendingUser, \PDO::PARAM_STR);
        $statement->bindParam(':receiver_username', $receivingUser, \PDO::PARAM_STR);
       // $statement->bindParam(':receiver', $receiverId, \PDO::PARAM_INT);
        $statement->bindParam(':text', $text, \PDO::PARAM_STR);
        $statement->bindParam(':about', $details, \PDO::PARAM_STR);
        $statement->bindParam(':stamp', $myTime, \PDO::PARAM_INT);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        if ($queryWasSuccessful) {
            return $connection->lastInsertId();
        } else {
            return null;
        }
    }




}