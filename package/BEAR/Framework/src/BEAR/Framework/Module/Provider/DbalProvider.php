<?php

namespace BEAR\Framework\Module\Provider;

use Ray\Di\InjectorInterface;
use Ray\Di\ProviderInterface as Provide;
use BEAR\Framework\Module\AbstractPrototypeProvider;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * PDO provider
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
     * New instance
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