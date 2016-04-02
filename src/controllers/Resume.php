<?php
/**
 * Created by PhpStorm.
 * User: Adam O'Connor
 * Date: 01/04/2016
 * Time: 23:29
 */

namespace Adamoconnorframeworks\Controller;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

class Resume extends DatabaseTable
{

    /**
     * first name of user.
     * @var
     */
    private $name;
    
    /**
     * second name of user.
     * @var
     */
    private $surname;

    /**
     * mobile number of user.
     * @var
     */
    private $number;

    /**
     * email of user.
     * @var
     */
    private $email;

    /**
     * image of the user.
     * @var
     */
    private $image;

    /**
     * address line 01.
     * @var
     */
    private $addressLine01;

    /**
     * address line 02.
     * @var
     */
    private $addressLine02;

    /**
     * city the user is from.
     * @var
     */
    private $city;

    /**
     * eircode or postal code of user.
     * @var
     */
    private $eircode;

    /**
     * country user is from.
     * @var
     */
    private $country;

    /**
     * previous employment of user.
     * @var
     */
    private $previousEmployment;

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
     * get the name in the form
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * set the name of the user
     * for the cv.
     * @param mixed $id
     */
    public function setName($name)
    {
        $this->id = $name;
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
     * get the email address form.
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * set the email address for
     * the form.
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * get the address line01.
     * @return mixed
     */
    public function getAddressLine01()
    {
        return $this->addressLine01;
    }

    /**
     * set the address line01.
     * @param mixed $addressLine01
     */
    public function setAddressLine01($addressLine01)
    {
        $this->addressLine01 = $addressLine01;
    }

    /**
     * get the address line02.
     * @return mixed
     */
    public function getAddressLine02()
    {
        return $this->addressLine02;
    }

    /**
     * set the address line02.
     * @param mixed $addressLine02
     */
    public function setAddressLine02($addressLine02)
    {
        $this->addressLine02 = $addressLine02;
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
    public function getPreviousEmployment()
    {
        return $this->previousEmployment;
    }

    /**
     * set the previous employment of the user
     * @param mixed $previousEmployment
     */
    public function setPreviousEmployment($previousEmployment)
    {
        $this->previousEmployment = $previousEmployment;
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
    
    
    public static function findMatchingUserId($userIdentification) {
        $userId = Resume::getUserById($userIdentification);
        
        if(null == $userId) {
            return false;
        }
    }

    /**
     * get the specific user id in the
     * user's table.
     * @param $userIdentification
     * @return mixed|null
     */
    public function getUserById($userIdentification) {
        $db = new DatabaseManager();
        $connection = $db->getDbh();
        
        $sql = 'SELECT * FROM users WHERE id=:identification';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':identification', $userIdentification, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();
        
        if($object = $statement->fetch()) {
            return $object;
        }   else {
            return null;
        }
    }
    
    
}