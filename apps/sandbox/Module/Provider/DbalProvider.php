<?php
namespace sandbox\Module\Provider;

use Ray\Di\ProviderInterface as Provide;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class DbalProvider implements Provide
{
    public function get()
    {
        $config = new Configuration;
        //..
        $connectionParams = [
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'password' => '',
        'dbname' => 'blogbear'

        ];
        $conn = DriverManager::getConnection($connectionParams, $config);

        return $conn;
    }
}
