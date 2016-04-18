<?php
/**
 * Created by PhpStorm.
 * User: Adam O'Connor
 * Date: 01/04/2016
 * Time: 23:29
 */

namespace Adamoconnorframeworks\Model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

class Resume extends DatabaseTable
{
    /**
     * the id of the resume.
     * @var int
     */
    private $id;

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
     * get the id of the user.
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set the id of the user.
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * get the resume by a email address
     * that has been used 
     * @param $emailAddress
     * @return mixed|null
     */
    public static function getOneByEmail($emailAddress)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM resume WHERE email=:email';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':email', $emailAddress, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }

    /**
     * get the resume by the username that
     * has been used by the user.
     * @param $username
     * @return mixed|null
     */
    public static function getOneByUsername($username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM resume WHERE email=:email';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':email', $username, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }

    /**
     * get the resume from the id that 
     * is inserted.
     * @param $id
     * @return mixed|null
     */
    public static function getOneById($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM resume WHERE id=:id';
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
     * delete the resume where the id
     * is the one to delete.
     * @param $id
     * @return bool
     */
    public static function deleteResume($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'DELETE FROM resume WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryWasSuccessful = $statement->execute();
        return $queryWasSuccessful;
    }

    /**
     * update a resume generically.
     * @param Resume $resume
     * @return null|string
    */
    public static function update(Resume $resume)
    {
        $id = $resume->getId();
        $email = $resume->getEmail();
        $name = $resume->getName();
        $surname = $resume->getSurname();
        $number = $resume->getNumber();
        $image = $resume->getImage();
        $employmentStatus = $resume->getStatus();
        $addressLine01 = $resume->getAddress();
        $addressLine02 = $resume->getTown();
        $city = $resume->getCity();
        $eircode = $resume->getEircode();
        $country = $resume->getCountry();
        $previousEmployment = $resume->getEmployment();
        $qualifications = $resume->getQualifications();
        $skills = $resume->getSkills();
    
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'UPDATE resume SET email=:email, name=:firstname, surname=:surname, number=:mynumber, image=:image, status=:status, address=:address,town =:town,
        city=:city, eircode=:eircode, country=:country, employment=:employment, qualifications=:qualifications, skills=:skills WHERE id=:id';

        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->bindParam(':email', $email, \PDO::PARAM_STR);
        $statement->bindParam(':firstname', $name, \PDO::PARAM_STR);
        $statement->bindParam(':surname', $surname, \PDO::PARAM_STR);
        $statement->bindParam(':mynumber', $number, \PDO::PARAM_INT);
        $statement->bindParam(':image', $image, \PDO::PARAM_STR);
        $statement->bindParam(':status', $employmentStatus, \PDO::PARAM_STR);
        $statement->bindParam(':address', $addressLine01, \PDO::PARAM_STR);
        $statement->bindParam(':town', $addressLine02, \PDO::PARAM_STR);
        $statement->bindParam(':city', $city, \PDO::PARAM_STR);
        $statement->bindParam(':eircode', $eircode, \PDO::PARAM_STR);
        $statement->bindParam(':country', $country, \PDO::PARAM_STR);
        $statement->bindParam(':employment', $previousEmployment, \PDO::PARAM_STR);
        $statement->bindParam(':qualifications', $qualifications, \PDO::PARAM_STR);
        $statement->bindParam(':skills', $skills, \PDO::PARAM_STR);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        if($queryWasSuccessful) {
            return $connection->lastInsertId();
        } else {
            return null;
        }
    }

    /**
     * update the user's cv where the id is the same thats 
     * being updated.
     * @param Resume $user
     * @param $id
     * @return mixed|null
     */
    public static function updateUserCv(Resume $user, $id)
    {
        $email = $user->getEmail();
        $status = $user->getStatus();

        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'UPDATE resume SET email=:email, status=:status WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->bindParam(':email', $email, \PDO::PARAM_STR);
        $statement->bindParam(':status', $status, \PDO::PARAM_STR);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        if($queryWasSuccessful) {
            return $connection->lastInsertId();
        } else {
            return 1;
        }
    }

    /**
     * insert the dummy data into the resume form,
     * when the student user creates and account.
     * @param Resume $resume
     * @return null|string
     */
    public static function insert(Resume $resume)
    {
        $id = $resume->getId();
        $email = $resume->getEmail();
        $name = 'Joe';
        $surname = 'Bloggs';
        $number = '00851234567';
        $image = 'noImage.jpg';
        $status = $resume->getStatus();
        $address = '123 Fake Street';
        $town = 'Springfield';
        $city = 'Dublin';
        $eircode = 'F4K£STR33T';
        $country = 'Ireland';
        $employment = 'sajsajsahsdss';
        $qualifications = 'sakjskjska';
        $skills = 'jaksjajsajsk';

        $db = new DatabaseManager();
        $connection = $db->getDbh();

        // INSERT INTO users (firstname, surname, id, mynumber, image, addressline01, addressline02, city, eircode, country, previousemployment, qualifications, skills)
        //VALUES (:firstname, :surname, :id, :mynumber, :image, addressline01, addressline02, :city, :eircode, :country, :previousemployment, :qualifications, :skills)
        $statement = $connection->prepare('INSERT into resume (id ,email, name, surname, number, image, status, address, town, city, eircode, country, employment, qualifications, skills)
        VALUES (:id, :email, :firstname, :surname, :mynumber, :image, :status, :address, :town, :city, :eircode, :country, :employment, :qualifications, :skills)');
        //$statement = $connection->prepare('INSERT into resume (firstname) VALUES (:firstname)');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
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
        if($queryWasSuccessful) {
            return $connection->lastInsertId();
        } else {
            return null;
        }
    }
    
}
