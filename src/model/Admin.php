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

class Admin extends DatabaseTable
{
    /**
     * @var
     */
    private $id;

    /**
     * id for each user email address.
     * @var
     */
    private $email;

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

    public function getId()
    {
        return $this->id;
    }

    /**
     * get the id of the user
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * set the id of the user
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
     * return success (or not) of attempting to find matching username/password in the repo
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public static function canFindMatchingUsernameAndPassword($username, $password)
    {
        $user = Admin::getOneByUsername($username);

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
     * if record exists with $username, return User object for that record
     * otherwise return 'null'
     * @param $username
     * @return mixed|null
     */
    public static function getOneByUsername($username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM admin WHERE username=:username';
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
    public static function getUsersEmailAndUsername($email, $username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM admin WHERE email = :email OR username = :username';
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
     * insert new user used for registration.
     * @param User $user
     * @return null|string
    */
    public static function insert(Admin $user)
    {
        $email = $user->getEmail();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $role = $user->getRole();

        $db = new DatabaseManager();
        $connection = $db->getDbh();

        // INSERT INTO users (id, username, password, role, employment)
        // VALUES (:id, :username, :password, :role, :employment)
        $statement = $connection->prepare('INSERT into admin (email, username, password, role) VALUES (:email, :username, :password, :role)');
        $statement->bindParam(':email', $email, \PDO::PARAM_STR);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->bindParam(':password', $password, \PDO::PARAM_STR); // there isn't a PARAM_FLOAT ...
        $statement->bindParam(':role', $role, \PDO::PARAM_STR);
        $statement->execute();

        $queryWasSuccessful = ($statement->rowCount() > 0);
        if ($queryWasSuccessful) {
            return $connection->lastInsertId();
        } else {
            return null;
        }
    }
}
