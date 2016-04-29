<?php

/**
 * used for the CRUD of the jobApplications that the
 * students have applied for these resume's are stored here.
 */

namespace Adamoconnorframeworks\model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

/**
 * Class JobApplications
 * @package Adamoconnorframeworks\model
 */
class JobApplications extends DatabaseTable
{
    /**
     * set the id of the application
     * @var int
     */
    private $id;
    
    /**
     * the id of the job.
     * @var int
     */
    private $job;

    /**
     * the email address of the resume.
     * @var string
     */
    private $email;

    /**
     * name on the cv.
     * @var string
     */
    private $name;

    /**
     * surname on the cv.
     * @var string
     */
    private $surname;

    /**
     * number on the cv.
     * @var int
     */
    private $number;

    /**
     * the name of the image needed.
     * @var string
     */
    private $image;

    /**
     * employment status of the user.
     * @var string 
     */
    private $status;

    /**
     * address of the cv
     * @var string
     */
    private $address;

    /** 
     * town of the cv user.
     * @var string
     */
    private $town;

    /**
     * get the city of the cv
     * @var string
     */
    private $city;

    /**
     * eircode of the cv.
     * @var string
     */
    private $eircode;

    /**
     * country of the cv.
     * @var string
     */
    private $country;

    /**
     * previous employment of the cv.
     * @var string
     */
    private $employment;

    /**
     * qualifications that the user holds.
     * @var
     */
    private $qualifications;

    /**
     * skills that the user holds.
     * @var
     */
    private $skills;


    /**
     * get the id of the job application
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * set the id of the application.
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    

    /**
     * get the id of the job.
     * @return mixed
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * set the id of the job.
     * @param mixed $id
     */
    public function setJob($job)
    {
        $this->job = $job;
    }
    
    /**
     * get the email address of the resume.
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * set the email address of the resume.
     * @param mixed $id
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * get the surname for form.
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * set the surname for form.
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * get the surname for form.
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * set the surname for form.
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * get the mobile number.
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * set the mobile number.
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * get the image of form.
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * set the image of the form.
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * get the employment status of the 
     * user's cv.
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * set the image of the form.
     * @param mixed $image
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * get the address line01.
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * set the address line01.
     * @param mixed $addressLine01
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * get the address line02.
     * @return mixed
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * set the address line02.
     * @param mixed $addressLine02
     */
    public function setTown($town)
    {
        $this->town = $town;
    }

    /**
     * get the city of form.
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * set the city of the form.
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * get the eircode or postcode.
     * @return mixed
     */
    public function getEircode()
    {
        return $this->eircode;
    }

    /**
     * set the eircode or postcode.
     * @param mixed $eircode
     */
    public function setEircode($eircode)
    {
        $this->eircode = $eircode;
    }

    /**
     * get the country from the form.
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * set the country from the form.
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * get the previous employment of the user.
     * @return mixed
     */
    public function getEmployment()
    {
        return $this->employment;
    }

    /**
     * set the previous employment of the user.
     * @param $employment
     */
    public function setEmployment($employment)
    {
        $this->employment = $employment;
    }

    /**
     * get qualifications of the user
     * @return mixed
     */
    public function getQualifications()
    {
        return $this->qualifications;
    }

    /**
     * set the qualifications of the user.
     * @param mixed $qualifications
     */
    public function setQualifications($qualifications)
    {
        $this->qualifications = $qualifications;
    }

    /**
     * get the user's skills
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * set the user's skills
     * @param mixed $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

    /**
     * get all of the applications
     * in the table.
     * @return array
     */
    public static function getAll()
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM applications';
        $statement = $connection->prepare($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        $objects = $statement->fetchAll();
        return $objects;
    }

    /**
     * get multiple job applications by using the
     * job id number.
     * @param $id
     * @return array
     */
    public static function getAllByJobId($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM applications WHERE job=:job ';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':job', $id, \PDO::PARAM_INT);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        $objects = $statement->fetchAll();
        return $objects;
    }

    /**
     * inserting a students resume for a job.
     * @param JobApplications $resume
     * @return bool
     */
    public static function insert(JobApplications $resume)
    {
        $id = $resume->getJob();
        $email = $resume->getEmail();
        $name = $resume->getName();
        $surname = $resume->getSurname();
        $number = $resume->getNumber();
        $image =  $resume->getImage();
        $status = $resume->getStatus();
        $address = $resume->getAddress();
        $town = $resume->getTown();
        $city = $resume->getCity();
        $eircode = $resume->getEircode();
        $country = $resume->getCountry();
        $employment = $resume->getEmployment();
        $qualifications = $resume->getQualifications();
        $skills = $resume->getSkills();

        $db = new DatabaseManager();
        $connection = $db->getDbh();

        // INSERT INTO users (firstname, surname, id, mynumber, image, addressline01, addressline02, city, eircode, country, previousemployment, qualifications, skills)
        //VALUES (:firstname, :surname, :id, :mynumber, :image, addressline01, addressline02, :city, :eircode, :country, :previousemployment, :qualifications, :skills)
        $statement = $connection->prepare('INSERT into applications (job ,email, name, surname, number, image, status, address, town, city, eircode, country, employment, qualifications, skills)
        VALUES (:job, :email, :firstname, :surname, :mynumber, :image, :status, :address, :town, :city, :eircode, :country, :employment, :qualifications, :skills)');
        //$statement = $connection->prepare('INSERT into resume (firstname) VALUES (:firstname)');
        $statement->bindParam(':job', $id, \PDO::PARAM_INT);
        $statement->bindParam(':email', $email, \PDO::PARAM_STR);
        $statement->bindParam(':firstname', $name, \PDO::PARAM_STR);
        $statement->bindParam(':surname', $surname, \PDO::PARAM_STR);
        $statement->bindParam(':mynumber', $number, \PDO::PARAM_INT);
        $statement->bindParam(':image', $image, \PDO::PARAM_STR);
        $statement->bindParam(':status', $status, \PDO::PARAM_STR);
        $statement->bindParam(':address', $address, \PDO::PARAM_STR);
        $statement->bindParam(':town', $town, \PDO::PARAM_STR);
        $statement->bindParam(':city', $city, \PDO::PARAM_STR);
        $statement->bindParam(':eircode', $eircode, \PDO::PARAM_STR);
        $statement->bindParam(':country', $country, \PDO::PARAM_STR);
        $statement->bindParam(':employment', $employment, \PDO::PARAM_STR);
        $statement->bindParam(':qualifications', $qualifications, \PDO::PARAM_STR);
        $statement->bindParam(':skills', $skills, \PDO::PARAM_STR);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        return true;
    }
}
