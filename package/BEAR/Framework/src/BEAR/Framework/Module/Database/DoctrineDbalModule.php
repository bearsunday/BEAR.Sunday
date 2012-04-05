<?php
/**
 * Module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
namespace BEAR\Framework\Module\Database;
use Ray\Di\Scope;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;

/**
 * DBAL module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class DoctrineDbalModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind()->annotatedWith('master_db')->toInstance(['driver' => 'pdo_mysql', 'host' => 'localhost', 'dbname' => 'blogbear', 'user' => 'root', 'password' => null, 'charset' => 'UTF8']);
        $this->bind()->annotatedWith('slave_db')->toInstance(['driver' => 'pdo_mysql', 'host' => 'localhost', 'dbname' => 'blogbear', 'user' => 'root', 'password' => null, 'charset' => 'UTF8']);
        $dbInjector = $this->requestInjection('\BEAR\Framework\Interceptor\DbInjector');
        $this->bindInterceptor(
                $this->matcher->annotatedWith('BEAR\Framework\Annotation\Db'),
                $this->matcher->any(),
                [$dbInjector]
        );
    }
}
