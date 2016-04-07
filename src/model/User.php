<?php

/**
 * @Author Adam O'Connor
 * class that gets user's details
 * for logging into the website aswell as
 * registering, for an account.
 */
namespace Adamoconnorframeworks\Model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

class User extends DatabaseTable
{
    /**
     * normal user is 1.
     */
    const ROLE_USER = 1;

    /**
     * admin or lecturer is 2.
     */
    const ROLE_ADMIN = 2;

    /**
     * employer is 3.
     */
    const ROLE_EMPLOYER = 3;

    /**
     * id for each user email address.
     * @var
     */
    private $id;

    /**
     * username for login
     * @var
     */
    private $username;

    /**
     * password for login
     * @var
     */
    private $password;

    /**
     * role of user 1 = student, 2 = admin/lecture, 3 = employer
     * @var
     */
    private $role;

    /**
     * if the user is employed or not.
     * @var
     */
    private $employment;

    /**
     * get the id of the user
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set the id of the user
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * get the username of the user.
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * set the username of user.
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * get the password of user.
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
    * hash the password before storing ...
    * @param mixed $password
    */
    public function setPassword($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->password = $hashedPassword;
    }

    /**
     * get the role of the user.
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * set users role lecture/employer/student
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * get the employment status
     * @return mixed
     */
    public function getEmployment()
    {
        return $this->employment;
    }

    /**
     * set the employment status
     * @param $employment
     */
    public function setEmployment($employment)
    {
        $this->employment = $employment;
    }

    /**
     * return success (or not) of attempting to find matching username/password in the repo
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public static function canFindMatchingUsernameAndPassword($username, $password)
    {
        $user = User::getOneByUsername($username);

        // if no record has this username, return FALSE
        if (null == $user) {
            return false;
        }

        // hashed correct password
        $hashedStoredPassword = $user->getPassword();

        // return whether or not hash of input password matches stored hash
        return password_verify($password, $hashedStoredPassword);
    }

    /**
     * check the registration table
     * to see if any details are the same.
     * @param $id
     * @param $username
     * @return bool
     */
    public static function checkRegistration($id)
    {

        //use details that the user has enter'd.
        $checkUsersDetails = User::getUsersIdAndName($id);
        if ($checkUsersDetails == null) {
            // no such user in database
            return false;
        } else {
            // user in database
            return true;
        }
    }

    /**
     * return the role of each user
     * @param $username
     * @return null
     */
    public static function canFindSpecificRoleOfUser($username)
    {
        $user = User::getOneByUsername($username);
        
        // if no record has no username return null.
        if ($user == null) {
            return null;
        }
        
        $storedRoleNumber = $user->getRole();
        return $storedRoleNumber;
    }

    /**
     * if record exists with $username, return User object for that record
     * otherwise return 'null'
     * @param $username
     * @return mixed|null
     */
    public static function getOneByUsername($username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM users WHERE username=:username';
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
     * find user specific username 
     * and id.
     * @param $identity
     * @param $username
     * @return mixed|null
     */
    public static function getUsersIdAndName($identity)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM users WHERE id = :id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $identity, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }

    /**
     * insert new user used for registration.
     * @param User $user
     * @return null|string
    */
    public static function insert(User $user)
    {
        $id = $user->getId();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $role = $user->getRole();
        $employment = $user->getEmployment();

        $db = new DatabaseManager();
        $connection = $db->getDbh();

        // INSERT INTO users (id, username, password, role, employment)
        // VALUES (:id, :username, :password, :role, :employment)
        $statement = $connection->prepare('INSERT into users (id, username, password, role, employment)
        VALUES (:id, :username, :password, :role, :employment)');
        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->bindParam(':password', $password, \PDO::PARAM_STR); // there isn't a PARAM_FLOAT ...
        $statement->bindParam(':role', $role, \PDO::PARAM_INT);
        $statement->bindParam(':employment', $employment, \PDO::PARAM_STR);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        if ($queryWasSuccessful) {
            return $connection->lastInsertId();
        } else {
            return null;
        }
    }
}
