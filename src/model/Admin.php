<?php

/**
 *  used for the CRUD of the admin table,
 * handles all the items in the database to
 * do with the lecture's of the website.
 */
namespace Adamoconnorframeworks\model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

/**
 * Class Admin
 * @package Adamoconnorframeworks\Model
 */

class Admin extends DatabaseTable
{
    /**
     * id of the admin table
     * @var int
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

    /**
     * get the id of admin
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * set the id of the admin.
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * get the email address of the user.
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * set the email address of the administrator.
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
     * set users role employer/student
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
     * return the role of each Admin
     * @param $username
     * @return null
     */
    public static function canFindSpecificRoleOfUser($username)
    {
        $user = Admin::getOneByUsername($username);

        // if no record has no username return null.
        if ($user == null) {
            return null;
        }

        $storedRole = $user->getRole();
        return $storedRole;
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
     * get the a single admin by 
     * the id of the admin.
     * @param $id
     * @return mixed|null
     */
    public static function getOneById($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM admin WHERE id=:id';
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
     * get all the administrators,
     * from the admin table.
     * @return array
     */
    public static function getAll()
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM admin';
        $statement = $connection->prepare($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        $objects = $statement->fetchAll();
        return $objects;
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
    }
}
