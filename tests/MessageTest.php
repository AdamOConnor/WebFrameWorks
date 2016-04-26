<?php

namespace ItbTest;

use Adamoconnorframeworks\Model\Message;

class MessageTest extends \PHPUnit_Extensions_Database_TestCase
{
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

    public function getDataSet()
    {
        $seedFilePath = __DIR__ . '/databaseXml/seedMessages.xml';
        return $this->createXMLDataSet($seedFilePath);
    }

    public function testNumRowsFromSeedData()
    {
        // arrange
        $numRowsAtStart = 1;
        $expectedResult = $numRowsAtStart;

        // act

        // assert
        $this->assertEquals($expectedResult, $this->getConnection()->getRowCount('applications'));
    }

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
    
}

