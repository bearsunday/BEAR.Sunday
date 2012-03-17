<?php

namespace BEAR\Framework\Module\Provider;

use Ray\Di\InjectorInterface,
    Ray\Di\ProviderInterface as Provide;
use BEAR\Framework\Module\AbstractSingletonProvider;

/**
 * PDO provider
 */
class PdoProvider extends AbstractSingletonProvider
{
    /**
     * New instance
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