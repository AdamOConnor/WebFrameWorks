<?php

/**
 * testing for the private messages of the model.
 */
namespace ItbTest;

use Adamoconnorframeworks\Model\Message;
use Adamoconnorframeworks\Model\PrivateMessage;

/**
 * Class PrivateMessageTest
 * @package ItbTest
 */
class PrivateMessageTest extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * get the connection of the database.
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
     * test the seeding of the data into the database.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     */
    public function getDataSet()
    {
        $seedFilePath = __DIR__ . '/databaseXml/seedPrivateMessages.xml';
        return $this->createXMLDataSet($seedFilePath);
    }

    /**
     * test the number of rows seeded into the database.
     */
    public function testNumRowsFromSeedData()
    {
        // arrange
        $numRowsAtStart = 3;
        $expectedResult = $numRowsAtStart;

        // act

        // assert
        $this->assertEquals($expectedResult, $this->getConnection()->getRowCount('private'));
    }

    /**
     * test get all in the database for private messages.
     */
    public function testGetAllAsObjectArray()
    {

        // arrange
        $product1 = new PrivateMessage();
        $product1->setId('7');
        $product1->setSender('adam');
        $product1->setReceiver('matt');
        $product1->setText('hello admin how are you');
        $product1->setAbout('Name Details');
        $product1->setTimestamp('1460730379');

        $product2 = new PrivateMessage();
        $product2->setId('9');
        $product2->setSender('admin');
        $product2->setReceiver('erica');
        $product2->setText('hello erica');
        $product2->setAbout('Name Details');
        $product2->setTimestamp('1460731054');

        $product3 = new PrivateMessage();
        $product3->setId('13');
        $product3->setSender('matt');
        $product3->setReceiver('adam');
        $product3->setText('hey adam nothing much yourself !!!');
        $product3->setAbout('Name Details');
        $product3->setTimestamp('1460745077');

        $expectedResult = [];
        $expectedResult[] = $product1;
        $expectedResult[] = $product2;
        $expectedResult[] = $product3;

        // act
        $result = PrivateMessage::getAll();

        // assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test updating the private message in the database.
     */
    public function testUpdateStatus()
    {
        //arrange
        //$status = 'Pending';
        $product = new PrivateMessage();
        $product->setText('hello');
        $product->setAbout('Name Details');
        $product->setTimestamp('1460745099');
        $id = '13';
        $expectedResult = true;

        //act
        $result = PrivateMessage::update($product, $id);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * testing the fail of the update.
     */
    public function testUpdateStatusFail()
    {
        //arrange
        $product = new PrivateMessage();
        $product->setText('hello');
        $product->setAbout('Name Details');
        $product->setTimestamp('1460745099');
        $id = '20';
        $expectedResult = false;

        //act
        $result = PrivateMessage::update($product, $id);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the database has new inserted,
     * private message.
     */
    public function testDatabaseContainsNewlyInsertedProduct()
    {
        // arrange
        $product = new PrivateMessage();
        $product->setId('14');
        $product->setSender('matt');
        $product->setReceiver('adam');
        $product->setText('Hello name details are good !!!');
        $product->setAbout('Name Details');
        $product->setTimestamp('1460745011');

        // create variable containing expected dataset (from XML)
        $dataFilePath = __DIR__ . '/databaseXml/expectedPrivateMessages.xml';
        $expectedTable = $this->createXMLDataSet($dataFilePath)->getTable('private');

        // act
        // add item to table in our test DB
        PrivateMessage::insert($product);

        // retrieve dataset from our test DB
        $productsInDatabaseAfterInsert = $this->getConnection()->createQueryTable(
            'private', 'SELECT * FROM private'
        );

        // assert
        $this->assertTablesEqual($expectedTable, $productsInDatabaseAfterInsert);
    }

    /**
     * test the deleting of the message.
     */
    public function testRowCountAfterDeleteOne()
    {
        // arrange
        $numRowsAtStart = 3;
        $this->assertEquals($numRowsAtStart, $this->getConnection()->getRowCount('private'), 'Pre-Condition');
        $expectedResult = 2;

        // act
        PrivateMessage::delete(7);
        $result = $this->getConnection()->getRowCount('private');

        // assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the getting message by id.
     */
    public function testGetOneById()
    {
        //arrange
        $product2 = new PrivateMessage();
        $product2->setId('9');
        $product2->setSender('admin');
        $product2->setReceiver('erica');
        $product2->setText('hello erica');
        $product2->setAbout('Name Details');
        $product2->setTimestamp('1460731054');

        $expectedResult = $product2;

        //act
        $result = PrivateMessage::getOneById(9);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the failure of no match of the id.
     */
    public function testGetOneByIdFail()
    {
        //arrange
        $expectedResult = null;

        //act
        $result = PrivateMessage::getOneById(20);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the setting of the id,
     */
    public function testSetId()
    {
        // Arrange
        $message = new PrivateMessage();
        $message->setId(1);

        $expectedResult = 1;
        // Act
        $result = $message->getId();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
