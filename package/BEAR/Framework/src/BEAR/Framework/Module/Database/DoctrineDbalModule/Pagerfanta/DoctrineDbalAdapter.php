<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Database\DoctrineDbalModule\Pagerfanta;

use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Pagerfanta\Adapter\AdapterInterface;
use BEAR\Framework\Module\Database\PagingQuery;

/**
 * DoctrineDbalAdapter.
 *
 * @author Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class DoctrineDbalAdapter implements AdapterInterface
{
    /**
     * Constructor
     *
     * @param DriverConnection $db
     * @param string           $query
     */
    public function __construct(DriverConnection $db, $query)
    {
        $this->query = new PagingQuery($db, $query);
    }

    /**
     * {@inheritdoc}
     */
    public function getNbResults()
    {
        return count($this->query);
    }

    /**
     * {@inheritdoc}
     */
    public function getSlice($offset, $length)
    {
        $iterator = $this->query->getIterator($offset, $length);

        return $iterator;
    }
}
