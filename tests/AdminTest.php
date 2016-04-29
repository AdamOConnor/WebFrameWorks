<?php

/**
 * used for testing the admin model.
 */
namespace ItbTest;

use Adamoconnorframeworks\Model\Admin;

/**
 * Class AdminTest
 * @package ItbTest
 */
class AdminTest extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * getting the connection to the database.
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
     * seed the data in the database.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     */
    public function getDataSet()
    {
        $seedFilePath = __DIR__ . '/databaseXml/seedAdmin.xml';
        return $this->createXMLDataSet($seedFilePath);
    }

    /**
     * test how many rows of seed data.
     */
    public function testNumRowsFromSeedData()
    {
        // arrange
        $numRowsAtStart = 1;
        $expectedResult = $numRowsAtStart;

        // act

        // assert
        $this->assertEquals($expectedResult, $this->getConnection()->getRowCount('admin'));
    }

    /**
     * test if all is the same as database.
     */
    public function testGetAllAsObjectArray()
    {

        // arrange
        $product1 = new Admin();
        $product1->setId('1');
        $product1->setUsername('admin');
        $product1->setEmail('admin@itb.ie');
        $product1->setPassword('admin');
        $product1->setRole('Lecturer');

        $expectedResult = [];
        $expectedResult[] = $product1;
        

        // act
        $result = Admin::getAll();

        // assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test to see if the newly inserted admin was
     * inserted.
     */
    public function testDatabaseContainsNewlyInsertedProduct()
    {
        // arrange
        $product = new Admin();
        $product->setUsername('matt');
        $product->setEmail('mattsmith@itb.ie');
        $product->setPassword('');
        $product->setRole('Lecturer');

        // create variable containing expected dataset (from XML)
        $dataFilePath = __DIR__ . '/databaseXml/expectedNewAdmin.xml';
        $expectedTable = $this->createXMLDataSet($dataFilePath)->getTable('admin');

        // act
        // add item to table in our test DB
        Admin::insert($product);

        // retrieve dataset from our test DB
        $productsInDatabaseAfterInsert = $this->getConnection()->createQueryTable(
            'admin', 'SELECT * FROM admin'
        );

        // assert
        $this->assertTablesEqual($expectedTable, $productsInDatabaseAfterInsert);
    }

    /**
     * test if the admins details are found for logging in.
     */
    public function testFindMatchingPasswordAndUsername()
    {
        //arrange
        $username = 'admin';
        $password = 'admin';
        $expectedResult = true;
        //act
        $result = Admin::canFindMatchingUsernameAndPassword($username, $password);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the failure of the matching password and username.
     */
    public function testFindMatchingPasswordAndUsernameFail()
    {
        //arrange
        $username = 'jimmy';
        $password = 'adam';
        $expectedResult = false;

        //act
        $result = Admin::canFindMatchingUsernameAndPassword($username, $password);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test getting details by email.
     */
    public function testGetAdminByEmailOrUsername()
    {
        //arrange
        $email = 'admin@itb.ie';

        $product = new Admin();
        $product->setId('1');
        $product->setEmail('admin@itb.ie');
        $product->setUsername('admin');
        $product->setPassword('admin');
        $product->setRole('Lecturer');

        $expectedResult = $product;
        //act
        $result = Admin::getUsersEmailAndUsername($email, 'admin');
        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test failure if no email of admin found.
     */
    public function testGetAdminByEmailOrUsernameFailed()
    {
        //arrange
        $email = 'jimbo@itb.ie';

        $expectedResult = null;
        //act
        $result = Admin::getUsersEmailAndUsername($email, 'jimbo');
        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test getting the admin by admin's id.
     */
    public function testGetAdminById()
    {
        //arrange
        $id = 1;

        $product = new Admin();
        $product->setId('1');
        $product->setEmail('admin@itb.ie');
        $product->setUsername('admin');
        $product->setPassword('admin');
        $product->setRole('Lecturer');

        $expectedResult = $product;
        //act
        $result = Admin::getOneById($id);
        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test admin failed to get id.
     */
    public function testGetAdminByIdFailed()
    {
        //arrange
        $id = 20;
        $expectedResult = null;
        //act
        $result = Admin::getOneById($id);
        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test get the user by the 'Lecture' role of that user.
     */
    public function testGetUserByLectureRole()
    {
        //arrange
        $username = 'admin';
        $expectedResult = 'Lecturer';
        //act
        $result = Admin::canFindSpecificRoleOfUser($username);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test failure of that role.
     */
    public function testGetUserByStudentRoleFailed()
    {
        //arrange
        $username = 'jimbo';
        $expectedResult = null;

        //act
        $result = Admin::canFindSpecificRoleOfUser($username);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test settin the id of specific id.
     */
    public function testSetId()
    {
        // Arrange
        $message = new Admin();
        $message->setId(1);

        $expectedResult = 1;
        // Act
        $result = $message->getId();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
