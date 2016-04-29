<?php

/**
 * model used to CRUD the private messages,
 * database.
 */
namespace Adamoconnorframeworks\model;

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
    private $sender;

    /**
     *receiving users name.
     * @var string
     */
    private $receiver;

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
     * get the id of the private message.
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
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * set the sending user's username.
     * @param $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * get the receiving users username.
     * @return string
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * set the receiving username of the 
     * private message.
     * @param $receiver
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
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

        $sql = 'SELECT * FROM private';
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

        $sql = 'UPDATE private SET text=:text, about=:about, timestamp=:myTime WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->bindParam(':text', $text, \PDO::PARAM_STR);
        $statement->bindParam(':about', $about, \PDO::PARAM_STR);
        $statement->bindParam(':myTime', $time, \PDO::PARAM_INT);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        if ($queryWasSuccessful) {
            return true;
        } else {
            return false;
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

        $sql = 'SELECT * FROM private WHERE id=:id';
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

        $statement = $connection->prepare('DELETE from private WHERE id=:id');
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
        $sendingUser = $message->getSender();
        $receivingUser = $message->getReceiver();
        $details = $message->getAbout();
        $text = $message->getText();
        $myTime = $message->getTimestamp();

        $db = new DatabaseManager();
        $connection = $db->getDbh();

        // INSERT INTO users (firstname, surname, id, mynumber, image, addressline01, addressline02, city, eircode, country, previousemployment, qualifications, skills)
        //VALUES (:firstname, :surname, :id, :mynumber, :image, addressline01, addressline02, :city, :eircode, :country, :previousemployment, :qualifications, :skills)
        $statement = $connection->prepare('INSERT into private (sender, receiver, text, about, timestamp)
        VALUES (:sender, :receiver, :text, :about, :stamp)');
        $statement->bindParam(':sender', $sendingUser, \PDO::PARAM_STR);
        $statement->bindParam(':receiver', $receivingUser, \PDO::PARAM_STR);
        $statement->bindParam(':text', $text, \PDO::PARAM_STR);
        $statement->bindParam(':about', $details, \PDO::PARAM_STR);
        $statement->bindParam(':stamp', $myTime, \PDO::PARAM_INT);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        return true;
    }
}
