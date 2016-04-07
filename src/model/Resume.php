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
    private $id;

    private $name;

    private $surname;

    private $number;

    private $image;

    private $status;

    private $address;

    private $town;

    private $city;

    private $eircode;

    private $country;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return mixed
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
     * set the previous employment of the user
     * @param mixed $previousEmployment
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
     * @param $emailAddress
     * @return mixed|null
     */
    public static function getOneByEmail($emailAddress)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM resume WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $emailAddress, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }

    /**
     * @param $username
     * @return mixed|null
     */
    public static function getOneByUsername($username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM resume WHERE id=:username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }

    /**
     * @param Resume $resume
     * @return null|string
 
    public static function update(Resume $resume)
    {
        $id = $resume->getId();
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

        $sql = 'UPDATE resume SET name=:firstname, surname=:surname, number=:mynumber, image=:image, status=:status, address=:address,town =:town,
        city=:city, eircode=:eircode, country=:country, employment=:employment, qualifications=:qualifications, skills=:skills WHERE id=:id';

        $statement = $connection->prepare($sql);

        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
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
*/
    /**
     * @param Resume $resume
     * @return null|string
     */
    public static function insert(Resume $resume)
    {
        $email = $resume->getId();
        $name = 'Joe';
        $surname = 'Bloggs';
        $number = '0851234567';
        $image = 'noImage.jpg';
        $employmentStatus = $resume->getStatus();
        $addressLine01 = '123 Fake Street';
        $addressLine02 = 'Springfield';
        $city = 'Dublin';
        $eircode = 'F4K£STR33T';
        $country = 'Ireland';
        $previousEmployment = 'sajsajsahsdss';
        $qualifications = 'sakjskjska';
        $skills = 'jaksjajsajsk';

        $db = new DatabaseManager();
        $connection = $db->getDbh();

        // INSERT INTO users (firstname, surname, id, mynumber, image, addressline01, addressline02, city, eircode, country, previousemployment, qualifications, skills)
        //VALUES (:firstname, :surname, :id, :mynumber, :image, addressline01, addressline02, :city, :eircode, :country, :previousemployment, :qualifications, :skills)
        $statement = $connection->prepare('INSERT into resume (name, surname, id, mynumber, image, status, address, town, city, eircode, country, employment, qualifications, skills)
        VALUES (:name, :surname, :id, :mynumber, :image, :status, :address, :town, :city, :eircode, :country, :employment, :qualifications, :skills)');
        //$statement = $connection->prepare('INSERT into resume (firstname) VALUES (:firstname)');

        $statement->bindParam(':id', $email, \PDO::PARAM_STR);
        $statement->bindParam(':name', $name, \PDO::PARAM_STR);
        $statement->bindParam(':surname', $surname, \PDO::PARAM_STR);
        $statement->bindParam(':mynumber', $number, \PDO::PARAM_INT);
        $statement->bindParam(':image', $image, \PDO::PARAM_STR);
        $statement->bindParam(':employmentstatus', $employmentStatus, \PDO::PARAM_STR);
        $statement->bindParam(':addressline01', $addressLine01, \PDO::PARAM_STR);
        $statement->bindParam(':addressline02', $addressLine02, \PDO::PARAM_STR);
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
    
}
