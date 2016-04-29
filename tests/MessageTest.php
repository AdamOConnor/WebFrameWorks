<?php
/**
 * the testing for the message model
 */
namespace ItbTest;

use Adamoconnorframeworks\Model\Message;

/**
 * Class MessageTest
 * @package ItbTest
 */
class MessageTest extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * get connection to  database.
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
     * seeding data to database.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     */
    public function getDataSet()
    {
        $seedFilePath = __DIR__ . '/databaseXml/seedMessages.xml';
        return $this->createXMLDataSet($seedFilePath);
    }

    /**
     * test number of rows for database.
     */
    public function testNumRowsFromSeedData()
    {
        // arrange
        $numRowsAtStart = 1;
        $expectedResult = $numRowsAtStart;

        // act

        // assert
        $this->assertEquals($expectedResult, $this->getConnection()->getRowCount('messages'));
    }

    /**
     * test get all in the database message model.
     */
    public function testGetAllAsObjectArray()
    {

        // arrange
        $product1 = new Message();

        $product1->setId('11');
        $product1->setEmail('admin@itb.ie');
        $product1->setText('duno ?');
        $product1->setUser('admin');
        $product1->setTimestamp('1460577489');

        $expectedResult = [];
        $expectedResult[] = $product1;

        // act
        $result = Message::getAll();

        // assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test insert new message into the database.
     */
    public function testDatabaseContainsNewlyInsertedProduct()
    {
        // arrange
        $product = new Message();
        $product->setId('12');
        $product->setEmail('adam-o-connor@hotmail.com');
        $product->setText('hello how are you ?');
        $product->setUser('adam');
        $product->setTimestamp('1460577338');

        // create variable containing expected dataset (from XML)
        $dataFilePath = __DIR__ . '/databaseXml/expectedMessages.xml';
        $expectedTable = $this->createXMLDataSet($dataFilePath)->getTable('messages');

        // act
        // add item to table in our test DB
        Message::insert($product);

        // retrieve dataset from our test DB
        $productsInDatabaseAfterInsert = $this->getConnection()->createQueryTable(
            'messages', 'SELECT * FROM messages'
        );

        // assert
        $this->assertTablesEqual($expectedTable, $productsInDatabaseAfterInsert);
    }

    /**
     * test getting the id in the message model.
     */
    public function testGetId()
    {
        // Arrange
        $message = new Message();
        $message->setId(1);

        $expectedResult = 1;
        // Act
        $result = $message->getId();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * testing the getting of the user.
     */
    public function testGetUser()
    {
        // Arrange
        $message = new Message();
        $message->setUser('adam');

        $expectedResult = 'adam';
        // Act
        $result = $message->getUser();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * testing of the getting of the email.
     */
    public function testGetEmail()
    {
        // Arrange
        $message = new Message();
        $message->setEmail('adam-o-connor@hotmail.com');

        $expectedResult = 'adam-o-connor@hotmail.com';
        // Act
        $result = $message->getEmail();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test getting of the text.
     */
    public function testGetText()
    {
        // Arrange
        $message = new Message();
        $message->setText('hello how are you');

        $expectedResult = 'hello how are you';
        // Act
        $result = $message->getText();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test getting of the timestamp.
     */
    public function testGetTimestamp()
    {
        // Arrange
        $message = new Message();
        $message->setTimestamp('1460577489');
        $expectedResult = 1460577489;

        // Act
        $result = $message->getTimestamp();

        $this->assertEquals($expectedResult, $result);
    }
}
