<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor;

use Doctrine\DBAL\Connection;

/**
 * Db setter interface
 *
 * @package    BEAR.Framework
 * @subpackage Intercetor
 */
interface DbSetter
{
    /**
     * Set db connection
     * 
     * @param Connection $db
     * 
     * @return void
     */
    public function setDb(Connection $db = null);
}
