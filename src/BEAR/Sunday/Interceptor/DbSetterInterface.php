<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Interceptor;

use Doctrine\DBAL\Driver\Connection as DriverConnection;

/**
 * Interface for Db setter
 *
 * @package    BEAR.Sunday
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
