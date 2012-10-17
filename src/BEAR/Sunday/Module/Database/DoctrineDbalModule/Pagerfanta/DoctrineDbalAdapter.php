<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Database\DoctrineDbalModule\Pagerfanta;

use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Pagerfanta\Adapter\AdapterInterface;
use BEAR\Sunday\Module\Database\PagingQuery;

/**
 * DoctrineDbal adapter.
 *
 * @package    BEAR.Sunday
 * @subpackage Module
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
        $this->query->setOffsetLength($offset, $length);
        $iterator = $this->query->getIterator();

        return $iterator;
    }
}
