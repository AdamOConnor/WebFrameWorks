<?php
/**
 * test the pending jobs model.
 */
namespace ItbTest;

use Adamoconnorframeworks\Model\JobApplications;
use Adamoconnorframeworks\Model\Pending;

/**
 * Class PendingTest
 * @package ItbTest
 */
class PendingTest extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * getting the connection of the database.
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
     * seed the data of the pending jobs.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     */
    public function getDataSet()
    {
        $seedFilePath = __DIR__ . '/databaseXml/seedPendingJobs.xml';
        return $this->createXMLDataSet($seedFilePath);
    }

    /**
     * test the number of rows seeded into database.
     */
    public function testNumRowsFromSeedData()
    {
        // arrange
        $numRowsAtStart = 2;
        $expectedResult = $numRowsAtStart;

        // act

        // assert
        $this->assertEquals($expectedResult, $this->getConnection()->getRowCount('jobs'));
    }

    /**
     * test get all of the pending jobs in the database.
     */
    public function testGetAllAsObjectArray()
    {

        // arrange
        $product1 = new Pending();
        $product1->setId('2');
        $product1->setStatus('Active');
        $product1->setUsername('glaxo');
        $product1->setCompany('Glaxo Technologies');
        $product1->setDescription('become a software developer with glaxo.');
        $product1->setPosition('Software Engineer');
        $product1->setTimestamp('1460988000');

        $product2 = new Pending();
        $product2->setId('3');
        $product2->setStatus('Active');
        $product2->setUsername('glaxo');
        $product2->setCompany('Glaxo Technologies');
        $product2->setDescription('new job test');
        $product2->setPosition('Graphic Designer');
        $product2->setTimestamp('1461095760');

        $expectedResult = [];
        $expectedResult[] = $product1;
        $expectedResult[] = $product2;

        // act
        $result = Pending::getAll();

        // assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the inserting of newly inserted pending job.
     */
    public function testDatabaseContainsNewlyInsertedProduct()
    {
        // arrange
        $product = new Pending();
        $product->setStatus('Active');
        $product->setUsername('glaxo');
        $product->setCompany('Glaxo Technologies');
        $product->setDescription('office manager position now open.');
        $product->setPosition('Office Manager');
        $product->setTimestamp('1460988111');

        // create variable containing expected dataset (from XML)
        $dataFilePath = __DIR__ . '/databaseXml/expectedPendingJobs.xml';
        $expectedTable = $this->createXMLDataSet($dataFilePath)->getTable('jobs');

        // act
        // add item to table in our test DB
        Pending::insert($product);

        // retrieve dataset from our test DB
        $productsInDatabaseAfterInsert = $this->getConnection()->createQueryTable(
            'jobs', 'SELECT * FROM jobs'
        );

        // assert
        $this->assertTablesEqual($expectedTable, $productsInDatabaseAfterInsert);
    }


    /**
     * test the deleting of a pending job.
     * count how many row's are left when deleted one.
     */
    public function testRowCountAfterDeleteOne()
    {

        // arrange
        $numRowsAtStart = 2;
        $this->assertEquals($numRowsAtStart, $this->getConnection()->getRowCount('jobs'), 'Pre-Condition');
        $expectedResult = 1;

        // act
        Pending::delete(2);
        $result = $this->getConnection()->getRowCount('jobs');

        // assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the updating of the status set by the admin
     * in the pending job model.
     */
    public function testUpdateStatus()
    {
        //arrange
        $status = 'Pending';
        $id = '2';
        $expectedResult = true;

        //act
        $result = Pending::updateStatus($status, $id);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the failing of the update status of the model.
     */
    public function testUpdateStatusFail()
    {
        //arrange
        $status = 'Active';
        $id = '6';
        $expectedResult = false;

        //act
        $result = Pending::updateStatus($status, $id);

        //assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * test the setting of the id.
     */
    public function testSetId()
    {
        // Arrange
        $message = new Pending();
        $message->setId(1);

        $expectedResult = 1;
        // Act
        $result = $message->getId();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
