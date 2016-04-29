<?php

/**
 * used for the CRUD of the normal users database,
 * such as students and employers.
 */
namespace Adamoconnorframeworks\model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

/**
 * Class User
 * @package Adamoconnorframeworks\Model
 */
class User extends DatabaseTable
{
    /**
     * id of the user.
     * @var int
     */
    private $id;
    
    /**
     * id for each user email address.
     * @var string
     */
    private $email;

    /**
     * username for login
     * @var string
     */
    private $username;

    /**
     * password for login
     * @var string
     */
    private $password;

    /**
     * role of user student ,employer
     * @var
     */
    private $role;

    /**
     * if the user is employed or not.
     * @var string
     */
    private $status;

    /**
     * get id of user
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * settin the id of the user.
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * get the email address of the user
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * set the email address of the user
     * @param mixed $id
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * set the employment status of the user.
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * return success (or not) of attempting to find matching username/password in the repo
     * @param $username
     * @param $password
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
     * @param $email
     * @param $username
     * @return bool
     */
    public static function checkRegistration($email, $username)
    {
        //use details that the user has enter'd.
        $checkUsersDetails = User::getUsersEmailAndUsername($email, $username);
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
     * get the user by the role of the user.
     * @param $role
     * @return mixed|null
     */
    public static function getUserByStudentRole($role)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM users WHERE role=:role';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':role', $role, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
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
     * get all the information by the email
     * address of the user.
     * @param $email
     * @return mixed|null
     */
    public static function getIdByEmail($email)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM users WHERE email=:email';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':email', $email, \PDO::PARAM_STR);
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
     * @param $email
     * @param $username
     * @return mixed|null
     */
    public static function getUsersEmailAndUsername($email, $username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM users WHERE email = :email OR username = :username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':email', $email, \PDO::PARAM_STR);
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
     * insert new user
     * @param User $user
     * @return null|string
     */
    public static function insert(User $user)
    {
        $email = $user->getEmail();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $role = $user->getRole();
        $status = $user->getStatus();

        $db = new DatabaseManager();
        $connection = $db->getDbh();

        // INSERT INTO users (id, username, password, role, employment)
        // VALUES (:id, :username, :password, :role, :employment)
        $statement = $connection->prepare('INSERT into users (email, username, password, role, status) VALUES (:email, :username, :password, :role, :status)');
        $statement->bindParam(':email', $email, \PDO::PARAM_STR);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->bindParam(':password', $password, \PDO::PARAM_STR); // there isn't a PARAM_FLOAT ...
        $statement->bindParam(':role', $role, \PDO::PARAM_STR);
        $statement->bindParam(':status', $status, \PDO::PARAM_STR);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        return true;
    }

    /**
     * admin update for student users.
     * login information.
     * @param User $user
     * @param $id
     * @return int|string
     */
    public static function updateUserLogin(User $user, $id)
    {
        $email = $user->getEmail();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $status = $user->getStatus();
        $role = $user->getRole();
        
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'UPDATE users SET email=:email, username=:username, password=:password, status=:status, role=:role WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->bindParam(':email', $email, \PDO::PARAM_STR);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->bindParam(':password', $password, \PDO::PARAM_STR);
        $statement->bindParam(':status', $status, \PDO::PARAM_STR);
        $statement->bindParam(':role', $role, \PDO::PARAM_STR);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        if ($queryWasSuccessful) {
            return true;
        } else {
            return false;
        }
    }
}
