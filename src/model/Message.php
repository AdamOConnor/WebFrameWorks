<?php
namespace Adamoconnorframeworks\Model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

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
     * set the id of the message.
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * get the id of the message.
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get email address of message.
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * get the text of the message.
     * @return string
     */
    public function getText()
    {
        return $this->text;
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
     * set the user that sent the message.
     * @param $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * get the user of the message.
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
        $dateTimeObject = new \DateTime();
        $dateTimeObject->setTimestamp($this->timestamp);

        return $dateTimeObject;
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