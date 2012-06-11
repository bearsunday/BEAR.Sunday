<?php

namespace BEAR\Framework\Tests;

use Pagerfanta\Pagerfanta;

use BEAR\Framework\Module\Database\Pager;
use BEAR\Framework\Module\Database\DoctrineDbalModule\Pagerfanta\DoctrineDbalAdapter;
use PDO;
use Doctrine\DBAL\DriverManager;

/**
 * Test class for Pager.
 */
class PagerTest extends \PHPUnit_Extensions_Database_TestCase
{
    private $pdo;

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        $this->pdo = new \PDO("mysql:host=localhost; dbname=blogbeartest", "root", "");
        return $this->createDefaultDBConnection($this->pdo, 'mysql');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__.'/Mock/pager_seed.xml');
    }

    protected function setUp()
    {
        parent::setUp();
        $params['pdo'] = $this->pdo;
        $db = DriverManager::getConnection($params);
        $this->query = 'SELECT * FROM posts';
        $this->pager = new Pager($db, new Pagerfanta(new DoctrineDbalAdapter($db, $this->query)));
    }

    public function test_New()
    {
        $this->assertInstanceOf('BEAR\Framework\Module\Database\Pager', $this->pager);
    }

    public function test_getPagerQuery()
    {
        $query = $this->pager->getPagerQuery($this->query);
        $expected = 'SELECT * FROM posts LIMIT 2 OFFSET 0';
        $this->assertSame($expected, $query);
    }
}
