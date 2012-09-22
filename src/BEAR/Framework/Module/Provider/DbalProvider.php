<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Provider;

use Ray\Di\ProviderInterface as Provide;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * PDO provider
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class DbalProvider implements Provide
{
    /**
     * @Inject
     * @Named("dsn=dsn");
     */
    public function setDsn($dsn)
    {
        $this->dsn = $dsn;
    }

    /**
     * Return instance
     *
     * @return Doctrine\DBAL\Connection
     */
    public function get()
    {
        $config = new \Doctrine\DBAL\Configuration();
        $connectionParams = [
            'driver' => 'pdo_sqlite',
            'path' => $this->dsn,
            'user' => null,
            'password' => null
        ];
        $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

        return $conn;
    }
}
