<?php

/**
 * used for CRUD normal messages in the
 * database.
 */
namespace Adamoconnorframeworks\model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

/**
 * Class Message
 * @package Adamoconnorframeworks\model
 */

class Message extends DatabaseTable
{
    /**
     * the object's unique ID
     * @var int
     */
    private $id;

    /**
     * the persons id sending message.
     * @var string $email
     */
    private $email;

    /**
     * text of the message.
     * @var string $text
     */
    private $text;

    /**
     * name of person who posted the text
     * @var string $user
     */
    private $user;

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
     * set the id of the message.
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * set the email address of the message.
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * get email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * set the text of the message.
     * @param $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * get the text.
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * set username.
     * @param $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * get the username.
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * set the timestamp of the message.
     * @param $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * get the timestamp as a PHP \DateTime object
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * get all of the messages from the,
     * message table in the database.
     * @return array
     */
    public static function getAll()
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM messages';
        $statement = $connection->prepare($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        $objects = $statement->fetchAll();
        return $objects;
    }
}
