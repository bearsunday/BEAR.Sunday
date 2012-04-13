<?php
/**
 * Module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
namespace BEAR\Framework\Module\Log;

use Ray\Di\Scope;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;

/**
 * DBAL module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class MonologModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('Guzzle\Common\Log\LogAdapterInterface')->toProvider('BEAR\Framework\Module\Log\MonologModule\MonologProvider');
    }
}
