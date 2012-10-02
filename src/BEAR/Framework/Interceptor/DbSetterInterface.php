<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use Doctrine\DBAL\Driver\Connection as DriverConnection;

/**
 * Interface for Db setter
 *
 * @package    BEAR.Framework
 * @subpackage Intercetor
 */
interface DbSetterInterface
{
    /**
     * Set db connection
     *
     * @param DriverConnection $db
     *
     * @return void
     */
    public function setDb(DriverConnection $db = null);
}
