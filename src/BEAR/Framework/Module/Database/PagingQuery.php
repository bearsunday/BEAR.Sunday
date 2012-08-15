<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Database;

use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Countable;
use PDO;
use ArrayIterator;
use IteratorAggregate;

/**
 * Paging Query
 *
 * @package    BEAR.Framework
 * @subpackage Database
 */
class PagingQuery implements Countable, IteratorAggregate
{
    /**
     * Total number
     *
     * @var int
     */
    private $count;

    /**
     * Constructor
     *
     * @param DriverConnection $db
     * @param string           $query
     * @param array            $params
     */
    public function __construct(DriverConnection $db, $query, array $params = array())
    {
        $this->db = $db;
        $this->pdo = $this->db->getWrappedConnection();
        $this->query = $query;
        $this->params = $params;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        if (! is_null($this->count)) {
            return $this->count;
        }
        $this->count = $this->getCountNum($this->query, $this->params);

        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator($offset, $length)
    {
        $pdo = $this->db->getWrappedConnection();
        $query = $this->getPagerSql($offset, $length);
        if ($this->params) {
            $result = $pdo->prepare($query)->execute($this->params)->fetchColumn();
        } else {
            $result = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        }

        return new ArrayIterator($result);
    }

    /**
     * Return pager sql
     *
     * @param int $offset
     * @param int $length
     *
     * @return string
     */
    public function getPagerSql($offset, $length)
    {
        $query = $this->db->getDatabasePlatform()->modifyLimitQuery($this->query, $length, $offset);

        return $query;
    }

    /**
     * Get count number
     *
     * @param string $query
     * @param array  $params
     *
     * @return int
     */
    private function getCountNum($query, array $params = array())
    {
        // be smart and try to guess the total number of records
        $countQuery = $this->getCountQuery($query);
        if ($countQuery) {
            if ($params) {
                $count = $this->pdo->prepare($countQuery)->execute($params)->fetchColumn();
            } else {
                $count = $this->pdo->query($countQuery)->fetchColumn();
            }
        } else {
            // GROUP BY => fetch the whole resultset and count the rows returned
            $result = $db->fetchAll($query);
            $count = count($result);
        }

        return (integer) $count;
    }

    /**
     * Get count query
     *
     * @param string $query
     *
     * @return string
     */
    public function getCountQuery($query)
    {
        if (preg_match('/^\s*SELECT\s+\bDISTINCT\b/is', $query) || preg_match('/\s+GROUP\s+BY\s+/is', $query)) {
            return false;
        }
        $openParenthesis = '(?:\()';
        $closeParenthesis = '(?:\))';
        $subqueryInSelect = $openParenthesis . '.*\bFROM\b.*' . $closeParenthesis;
        $pattern = '/(?:.*' . $subqueryInSelect . '.*)\bFROM\b\s+/Uims';
        if (preg_match($pattern, $query)) {
            return false;
        }
        $subqueryWithLimitOrder = $openParenthesis . '.*\b(LIMIT|ORDER)\b.*' . $closeParenthesis;
        $pattern = '/.*\bFROM\b.*(?:.*' . $subqueryWithLimitOrder . '.*).*/Uims';
        if (preg_match($pattern, $query)) {
            return false;
        }
        $queryCount = preg_replace('/(?:.*)\bFROM\b\s+/Uims', 'SELECT COUNT(*) FROM ', $query, 1);
        list($queryCount, ) = preg_split('/\s+ORDER\s+BY\s+/is', $queryCount);
        list($queryCount, ) = preg_split('/\bLIMIT\b/is', $queryCount);

        return trim($queryCount);
    }
}
