<?php

namespace demoWorld\Module;

use Ray\Di\InjectorInterface,
    Ray\Di\ProviderInterface;
use BEAR\Framework\Module\Singleton;

/**
 * PDO provider
 */
class DoctrineProvider implements ProviderInterface
{
    use Singleton;
    
    /**
     * Return new instance
     * 
     * @return \PDO
     */
    public function newInstance()
    {
        //$dbfile = dirname(__DIR__) . '/tmp/demo01.sqlite3';
        $dbfile = '/tmp/demo01.sqlite3';
        $instance = new \PDO('sqlite:' .$dbfile, null, null);
        $instance->query("CREATE TABLE User (Id INTEGER PRIMARY KEY, Name TEXT, Age INTEGER)");
        return $instance;
    }
}