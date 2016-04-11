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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
   {
        $this->email = $email;
   }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getUser()
    {
        return $this->user;
    }

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