<?php

/**
 * test the resume model.
 */
namespace ItbTest;

use Adamoconnorframeworks\Model\Resume;

/**
 * Class ResumeTest
 * @package ItbTest
 */
class ResumeTest extends \PHPUnit_Extensions_Database_TestCase
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
     * test seeding the data to the database. 
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     */
    public function getDataSet()
    {
        $seedFilePath = __DIR__ . '/databaseXml/seedResume.xml';
        return $this->createXMLDataSet($seedFilePath);
    }

    /**
     * test get number of rows from seed data.
     */
    public function testNumRowsFromSeedData()
    {
        // arrange
        $numRowsAtStart = 1;
        $expectedResult = $numRowsAtStart;

        // act

        // assert
        $this->assertEquals($expectedResult, $this->getConnection()->getRowCount('resume'));
    }

    /**
     * test new resume into the database.
     */
    public function testDatabaseContainsNewlyInsertedProduct()
    {
        // arrange
        $product = new Resume();
        $product->setId('2');
        $product->setEmail('hogarty.erica@hotmail.com');
        $product->setStatus('employed');

        // create variable containing expected dataset (from XML)
        $expectedResult = true;

        // act
        // add item to table in our test DB
        $result = Resume::insert($product);
        
        // assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test updating of the resume
     */
    public function testUpdateStatus()
    {
        //arrange
        $product = new Resume();
        $product->setId('1');
        $product->setEmail('adam-o-connor@hotmail.com');
        $product->setName('Adam');
        $product->setSurname('OConnor');
        $product->setNumber('0851234567');
        $product->setImage('noImage.jpg');
        $product->setStatus('employed');
        $product->setAddress('123 Fake Street');
        $product->setTown('Springfield');
        $product->setCity('Dublin');
        $product->setEircode('F4KÂ£STR33T');
        $product->setCountry('Ireland');
        $product->setEmployment('sajsajsahsdss');
        $product->setQualifications('sakjskjska');
        $product->setSkills('jaksjajsajsk');

        $expectedResult = true;
        
        //act
        $result = Resume::update($product);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the failing of the updating of the resume.
     */
    public function testFailUpdateStatus()
    {
        //arrange
        $product = new Resume();
        $product->setId('30');
        $product->setEmail('adam-o-connor@hotmail.com');
        $product->setName('Adam');
        $product->setSurname('OConnor');
        $product->setNumber('0851234567');
        $product->setImage('noImage.jpg');
        $product->setStatus('employed');
        $product->setAddress('123 Fake Street');
        $product->setTown('Springfield');
        $product->setCity('Dublin');
        $product->setEircode('F4KÂ£STR33T');
        $product->setCountry('Ireland');
        $product->setEmployment('sajsajsahsdss');
        $product->setQualifications('sakjskjska');
        $product->setSkills('jaksjajsajsk');

        $expectedResult = false;

        //act
        $result = Resume::update($product);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the update of the email and status from admin.
     */
    public function testUpdateEmailAndStatusAdmin()
    {
        //arrange
        $product = new Resume();
        $product->setEmail('adamoconnor94@gmail.com');
        $product->setStatus('employed');
        $id = 1;
        $expectedResult = true;

        //act
        $result = Resume::updateUserCv($product, $id);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the failing of updating email and status.
     */
    public function testUpdateEmailAndStatusAdminFailed()
    {
        //arrange
        $product = new Resume();
        $product->setEmail('adamoconnor94@gmail.com');
        $product->setStatus('employed');
        $id = 30;
        $expectedResult = false;

        //act
        $result = Resume::updateUserCv($product, $id);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test getting one by the id.
     */
    public function testGetOneById()
    {
        //arrange
        $id = 1;

        $product = new Resume();
        $product->setId('1');
        $product->setEmail('adam-o-connor@hotmail.com');
        $product->setName('Joe');
        $product->setSurname('Bloggs');
        $product->setNumber('0851234567');
        $product->setImage('noImage.jpg');
        $product->setStatus('employed');
        $product->setAddress('123 Fake Street');
        $product->setTown('Springfield');
        $product->setCity('Dublin');
        $product->setEircode('F4KÂ£STR33T');
        $product->setCountry('Ireland');
        $product->setEmployment('sajsajsahsdss');
        $product->setQualifications('sakjskjska');
        $product->setSkills('jaksjajsajsk');

        $expectedResult = $product;

        //act
        $result = Resume::getOneById($id);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test getting failed for the id.
     */
    public function testGetOneByIdFail()
    {
        //arrange
        $id = 20;
        $expectedResult = null;

        //act
        $result = Resume::getOneById($id);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * testing get resume by the email of a user.
     */
    public function testGetOneByEmail()
    {
        //arrange
        $email = 'adam-o-connor@hotmail.com';

        $product = new Resume();
        $product->setId('1');
        $product->setEmail('adam-o-connor@hotmail.com');
        $product->setName('Joe');
        $product->setSurname('Bloggs');
        $product->setNumber('0851234567');
        $product->setImage('noImage.jpg');
        $product->setStatus('employed');
        $product->setAddress('123 Fake Street');
        $product->setTown('Springfield');
        $product->setCity('Dublin');
        $product->setEircode('F4KÂ£STR33T');
        $product->setCountry('Ireland');
        $product->setEmployment('sajsajsahsdss');
        $product->setQualifications('sakjskjska');
        $product->setSkills('jaksjajsajsk');

        $expectedResult = $product;

        //act
        $result = Resume::getOneByEmail($email);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test getting by user email failed.
     */
    public function testGetOneByEmailFail()
    {
        //arrange
        $email = 'timothy@hotmail.com';

        $expectedResult = null;

        //act
        $result = Resume::getOneByEmail($email);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test deleting a resume.
     */
    public function testRowCountAfterDeleteOne()
    {
        // arrange
        $numRowsAtStart = 1;
        $this->assertEquals($numRowsAtStart, $this->getConnection()->getRowCount('resume'), 'Pre-Condition');
        $expectedResult = 0;

        // act
        Resume::deleteResume(1);
        $result = $this->getConnection()->getRowCount('resume');

        // assert
        $this->assertEquals($expectedResult, $result);
    }
}
