<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use Doctrine\DBAL\Driver\Connection as DriverConnection;

/**
 * Db setter interface
 *
 * @package    BEAR.Framework
 * @subpackage Intercetor
 */
interface DbSetterInterface
{
    /**
     * Set db connection
     *
     * @param Connection $db
     *
     * @return void
     */
    public function setDb(DriverConnection $db = null);
}
