<?php

/**
 * testing of the user model
 */
namespace ItbTest;

use Adamoconnorframeworks\Model\JobApplications;
use Adamoconnorframeworks\Model\Pending;
use Adamoconnorframeworks\Model\User;

/**
 * Class UserTest
 * @package ItbTest
 */
class UserTest extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * get connection of the database.
     * @return \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
     */
    public function getConnection()
    {
        $host = DB_HOST;
        $dbName = DB_NAME;
        $dbUser = DB_USER;
        $dbPass = DB_PASS;

        // mysql
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbName;
        $db = new \PDO($dsn, $dbUser, $dbPass);
        $connection = $this->createDefaultDBConnection($db, $dbName);

        return $connection;
    }

    /**
     * test the seeding of data to the database.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     */
    public function getDataSet()
    {
        $seedFilePath = __DIR__ . '/databaseXml/seedUsers.xml';
        return $this->createXMLDataSet($seedFilePath);
    }

    /**
     * test the number of rows from seeding data.
     */
    public function testNumRowsFromSeedData()
    {
        // arrange
        $numRowsAtStart = 2;
        $expectedResult = $numRowsAtStart;

        // act

        // assert
        $this->assertEquals($expectedResult, $this->getConnection()->getRowCount('users'));
    }

    /**
     * test the get all method of the user.
     */
    public function testGetAllAsObjectArray()
    {

        // arrange
        $product1 = new User();
        $product1->setId('1');
        $product1->setEmail('adam-o-connor@hotmail.com');
        $product1->setUsername('adam');
        $product1->setPassword('adam');
        $product1->setRole('Student');
        $product1->setStatus('employed');

        $product2 = new User();
        $product2->setId('2');
        $product2->setEmail('hogarty.erica@gmail.com');
        $product2->setUsername('erica');
        $product2->setPassword('erica');
        $product2->setRole('Student');
        $product2->setStatus('unemployed');

        $expectedResult = [];
        $expectedResult[] = $product1;
        $expectedResult[] = $product2;
        // act
        $result = User::getAll();

        // assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test insert user into the database.
     */
    public function testDatabaseContainsNewlyInsertedProduct()
    {
        // arrange
        $product = new User();
        $product->setEmail('employer@itb.ie');
        $product->setUsername('Glaxo');
        $product->setPassword('ss');
        $product->setRole('Employer');
        $product->setStatus('employed');

        // create variable containing expected dataset (from XML)
        $dataFilePath = __DIR__ . '/databaseXml/expectedUsers.xml';
        $expectedTable = $this->createXMLDataSet($dataFilePath)->getTable('users');

        // act
        // add item to table in our test DB
        User::insert($product);

        // retrieve dataset from our test DB
        $productsInDatabaseAfterInsert = $this->getConnection()->createQueryTable(
            'users', 'SELECT * FROM users'
        );

        // assert
        $this->assertTablesEqual($expectedTable, $productsInDatabaseAfterInsert);
    }

    /**
     * test the finding of the matching of the password and username.
     */
    public function testFindMatchingPasswordAndUsername()
    {
        //arrange
        $username = 'adam';
        $password = 'adam';
        $expectedResult = true;
        //act
        $result = User::canFindMatchingUsernameAndPassword($username, $password);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the failure of the username and password.
     */
    public function testFindMatchingPasswordAndUsernameFail()
    {
        //arrange
        $username = 'jimmy';
        $password = 'adam';
        $expectedResult = false;

        //act
       $result = User::canFindMatchingUsernameAndPassword($username, $password);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the checking of username in database for registration form.
     */
    public function testCheckRegistration()
    {
        //arrange
        $username = 'adam';
        $email = 'adam-o-connor@hotmail.com';
        $expectedResult = true;
        //act
        $result = User::checkRegistration($email, $username);
        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * testing the failure of the checking of the details.
     */
    public function testCheckRegistrationFailed()
    {
        //arrange
        $username = 'connor';
        $email = 'connor@hotmail.com';
        $expectedResult = false;
        //act
        $result = User::checkRegistration($email, $username);
        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the getting of the user's role in the database.
     */
    public function testGetSpecificRole()
    {
        //arrange
        $username = 'adam';
        $expectedResult = 'Student';
        //act
        $result = User::canFindSpecificRoleOfUser($username);
        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the failure of the specific role.
     */
    public function testGetSpecificRoleFailed()
    {
        //arrange
        $username = 'jimmy';
        $expectedResult = null;
        //act
        $result = User::canFindSpecificRoleOfUser($username);
        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the getting of info by the email of user.
     */
    public function testGetIdByEmail()
    {
        //arrange
        $email = 'adam-o-connor@hotmail.com';

        $product = new User();
        $product->setId('1');
        $product->setEmail('adam-o-connor@hotmail.com');
        $product->setUsername('adam');
        $product->setPassword('adam');
        $product->setRole('Student');
        $product->setStatus('employed');

        $expectedResult = $product;
        //act
        $result = User::getIdByEmail($email);
        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test getting the user by the student role in the db.
     */
    public function testGetUserByStudentRole()
    {
        //arrange
        $role = 'Student';

        $product = new User();
        $product->setId('1');
        $product->setEmail('adam-o-connor@hotmail.com');
        $product->setUsername('adam');
        $product->setPassword('adam');
        $product->setRole('Student');
        $product->setStatus('employed');

        $expectedResult = $product;

        //act
        $result = User::getUserByStudentRole($role);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the failure of getting the student role.
     */
    public function testGetUserByStudentRoleFail()
    {
        //arrange
        $role = 'Boss';

        $expectedResult = null;

        //act
        $result = User::getUserByStudentRole($role);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test getting the id by user's email fail.
     */
    public function testGetIdByEmailFail()
    {
        //arrange
        $email = 'timothy@hotmail.com';

        $expectedResult = null;
        //act
        $result = User::getIdByEmail($email);
        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the updating of the user's login info.
     */
    public function testUpdateUserLogin()
    {
        //arrange
        $product = new User();
        $product->setEmail('adam-o-connor@hotmail.com');
        $product->setUsername('smooth');
        $product->setPassword('smooth');
        $product->setRole('Student');
        $product->setStatus('employed');
        $id = 1;
        $expectedResult = true;

        //act
        $result = User::updateUserLogin($product, $id);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the update user's login failing.
     */
    public function testUpdateUserLoginFailed()
    {
        //arrange
        $product = new User();
        $product->setEmail('adam-o-connor@hotmail.com');
        $product->setUsername('smooth');
        $product->setPassword('smooth');
        $product->setRole('Student');
        $product->setStatus('employed');
        $id = 20;
        $expectedResult = false;

        //act
        $result = User::updateUserLogin($product, $id);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test setting the password.
     */
    public function testSetpassword()
    {
        // Arrange
        $st = new User();
        $password = "password";
        $expectedResult = $password;

        $st->setPassword($expectedResult);

        // Act
        $result = $st->getPassword();
        $bool = password_verify("password", $result);
        // Assert
        $this->assertTrue($bool);
    }

    /**
     * test the setting of the id.
     */
    public function testSetId()
    {
        // Arrange
        $message = new User();
        $message->setId(1);

        $expectedResult = 1;
        // Act
        $result = $message->getId();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
