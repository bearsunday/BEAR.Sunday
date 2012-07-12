<?php

namespace BEAR\Framework\Tests;

use BEAR\Framework\Module\Database\PagingQuery;
use PDO;
use Doctrine\DBAL\DriverManager;

/**
 * Test class for Pager.
 */
class PagingQueryTest extends \PHPUnit_Extensions_Database_TestCase
{
    private $pdo;

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        $this->pdo = require __DIR__ . '/scripts/db.php';;

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
        $this->sql = 'SELECT * FROM posts';
        $this->pager = new PagingQuery($db, $this->sql);
    }

    public function test_New()
    {
        $this->assertInstanceOf('BEAR\Framework\Module\Database\PagingQuery', $this->pager);
    }

    public function test_count()
    {
        $count = count($this->pager);
        $this->assertSame(5, (integer) $count);
    }

    public function test_getPagerSql()
    {
        $result = $this->pager->getPagerSql(0, 10);
        $expected = 'SELECT * FROM posts LIMIT 10 OFFSET 0';
        $this->assertSame($expected, $result);
    }

    public function test_getIterator()
    {
        $offset = 1;
        $length = 2;
        $result = $this->pager->getIterator($offset, $length);
        $this->assertSame(2, (integer) $result[0]['id']);
        $this->assertSame(3, (integer) $result[1]['id']);
        $this->assertSame(2, count($result));
    }
}
