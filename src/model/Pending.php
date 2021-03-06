<?php

/**
 * pending_jobs model used for the employer to send jobs.
 * and so the lecturer can see these jobs.
 */
namespace Adamoconnorframeworks\model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

/**
 * Class Pending
 * @package Adamoconnorframeworks\Model
 */

class Pending extends DatabaseTable
{
    /**
     * the object's unique ID.
     * @var int
     */
    private $id;

    /**
     * status of the job
     * @var string
     */
    private $status;

    /**
     * username of the employer.
     * @var string
     */
    private $username;

    /**
     * username of the employer.
     * @var string
     */
    private $company;

    /**
     * description of the job.
     * @var string
     */
    private $description;

    /**
     * position of the job.
     * @var string
     */
    private $position;

    /**
     * timestamp for deadline of the job.
     * @var int
     */
    private $timestamp;

    /**
     * get the id of the pending job
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * setting the id of the pending job.
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * get the status of the job.
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * set the status of the job.
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * get the username of the employer.
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * setting username of the employer.
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * get the company of employer.
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * setting the company of the employer.
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }
    
    /**
     * get the description of the job
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * set the description of the job.
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * get the position the job is entailed for.
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * set the postion the job is entailed for.
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * get the timestamp for the deadline.
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * set the timestamp for the deadline.
     * @param int $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * get all the details for the pending jobs,
     * in the pending_jobs table.
     * @return array
     */
    public static function getAll()
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM jobs';
        $statement = $connection->prepare($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        $objects = $statement->fetchAll();
        return $objects;
    }

    /*public static function getOneByUsername($username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM jobs WHERE username=:username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }*/

    /**
     * inserting a pending job into the database table.
     * @param Pending $job
     * @return string
     */
    public static function insert(Pending $job)
    {
        $status = $job->getStatus();
        $username = $job->getUsername();
        $company = $job->getCompany();
        $description = $job->getDescription();
        $position = $job->getPosition();
        $time = $job->getTimestamp();

        $db = new DatabaseManager();
        $connection = $db->getDbh();

        // INSERT INTO users (firstname, surname, id, mynumber, image, addressline01, addressline02, city, eircode, country, previousemployment, qualifications, skills)
        //VALUES (:firstname, :surname, :id, :mynumber, :image, addressline01, addressline02, :city, :eircode, :country, :previousemployment, :qualifications, :skills)
        $statement = $connection->prepare('INSERT into jobs (status, username, company, description, position, timestamp)
        VALUES (:status, :username, :company, :description, :jobposition, :mytime)');
        $statement->bindParam(':status', $status, \PDO::PARAM_STR);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->bindParam(':company', $company, \PDO::PARAM_STR);
        $statement->bindParam(':description', $description, \PDO::PARAM_STR);
        $statement->bindParam(':jobposition', $position, \PDO::PARAM_STR);
        $statement->bindParam(':mytime', $time, \PDO::PARAM_STR);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        return true;
    }

    /**
     * delete a job from the pending jobs table.
     * @param $id
     * @return bool
     */
    public static function delete($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'DELETE FROM jobs WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryWasSuccessful = $statement->execute();
        return $queryWasSuccessful;
    }

    /**
     * updating the status of the job
     * so that the lecturer can make that job become active.
     * @param $status
     * @param $id
     * @return bool
     */
    public static function updateStatus($status, $id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'UPDATE jobs SET status=:status WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->bindParam(':status', $status, \PDO::PARAM_STR);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        if ($queryWasSuccessful) {
            return true;
        } else {
            return false;
        }
    }
}
