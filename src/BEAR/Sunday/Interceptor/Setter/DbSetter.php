<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Interceptor\Setter;

use Doctrine\DBAL\Driver\Connection;

/**
 * Set Db
 *
 * @package    BEAR.Sunday
 * @subpackage Inject
 */
trait DbSetter
{
    /**
     * DB
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    /**
     * Set DB
     *
     * @param Connection $db
     *
     * @return void
     */
    public function setDb(Connection $db = null)
    {
        $this->db = $db;
    }
}
