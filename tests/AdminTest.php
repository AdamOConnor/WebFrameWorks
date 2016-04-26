<?php

namespace ItbTest;

use Adamoconnorframeworks\Model\Admin;

class AdminTest extends \PHPUnit_Extensions_Database_TestCase
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
        $seedFilePath = __DIR__ . '/databaseXml/seedAdmin.xml';
        return $this->createXMLDataSet($seedFilePath);
    }

    public function testNumRowsFromSeedData()
    {
        // arrange
        $numRowsAtStart = 1;
        $expectedResult = $numRowsAtStart;

        // act

        // assert
        $this->assertEquals($expectedResult, $this->getConnection()->getRowCount('admin'));
    }

    public function testGetAllAsObjectArray()
    {

        // arrange
        $product1 = new Admin();
        $product1->setId('1');
        $product1->setUsername('admin');
        $product1->setEmail('admin@itb.ie');
        $product1->setRole('Lecturer');

        $expectedResult = [];
        $expectedResult[] = $product1;

        // act
        $result = Admin::getAll();

        // assert
        $this->assertEquals($expectedResult, $result);

    }

    /*public function testDatabaseContainsNewlyInsertedProduct()
    {
        // arrange
        $product = new Admin();
        $product->setUsername('matt');
        $product->setEmail('mattsmith@itb.ie');
        $product->setPassword('smith');
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
    }*/

}

