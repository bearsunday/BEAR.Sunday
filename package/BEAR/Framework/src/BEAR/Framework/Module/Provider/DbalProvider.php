<?php

namespace BEAR\Framework\Module\Provider;

use Ray\Di\InjectorInterface,
    Ray\Di\ProviderInterface as Provide;
use BEAR\Framework\Module\AbstractPrototypeProvider;

/**
 * PDO provider
 */
class DbalProvider implements Provide
// class DbalProvider extends AbstractPrototypeProvider
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
//     public function newInstance()
    public function get()
    {
        $config = new \Doctrine\DBAL\Configuration();
        //..
        $connectionParams = [
            'driver' => 'pdo_sqlite',
            'path' => $this->dsn,
        	'user' => null,
            'password' => null
        ];
        $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
        serialize($conn);
        return $conn;
    }
}