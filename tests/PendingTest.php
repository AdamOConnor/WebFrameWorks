<?php

namespace ItbTest;

use Adamoconnorframeworks\Model\JobApplications;

class PendingTest extends \PHPUnit_Extensions_Database_TestCase
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
        $seedFilePath = __DIR__ . '/databaseXml/seedApplications.xml';
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
        $product1 = new JobApplications();

        $product1->setId('1');
        $product1->setJob('2');
        $product1->setName('Joe');
        $product1->setSurname('Bloggs');
        $product1->setEmail('adam-o-connor@hotmail.com');
        $product1->setNumber('851234567');
        $product1->setImage('noImage.jpg');
        $product1->setStatus('employed');
        $product1->setAddress('123 Fake Street');
        $product1->setTown('Springfield');
        $product1->setCity('Dublin');
        $product1->setEircode('F4KÂ£STR33T');
        $product1->setCountry('Ireland');
        $product1->setEmployment('sajsajsahsdss');
        $product1->setQualifications('sakjskjska');
        $product1->setSkills('jaksjajsajsk');

        $expectedResult = [];
        $expectedResult[] = $product1;
        //$expectedResult[] = $product2;

        // act
        $result = JobApplications::getAll();

        // assert
        $this->assertEquals($expectedResult, $result);

    }

    /*public function testDatabaseContainsNewlyInsertedProduct()
    {
        // arrange
        $product = new JobApplications();
        $product->setId('2');
        $product->setJobId('2');
        $product->setName('Joe');
        $product->setSurname('Bloggs');
        $product->setEmail('hogarty.erica@hotmail.com');
        $product->setNumber('851234567');
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

        // create variable containing expected dataset (from XML)
        $dataFilePath = __DIR__ . '/databaseXml/expectedProductswithResume.xml';
        $expectedTable = $this->createXMLDataSet($dataFilePath)->getTable('applications');

        // act
        // add item to table in our test DB
        JobApplications::insert($product);

        // retrieve dataset from our test DB
        $productsInDatabaseAfterInsert = $this->getConnection()->createQueryTable(
            'applications', 'SELECT * FROM applications'
        );

        // assert
        $this->assertTablesEqual($expectedTable, $productsInDatabaseAfterInsert);
    }*/
    
}

