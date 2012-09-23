<?php
/**
 * Module
 *
 * @package    helloworld
 * @subpackage Module
 */
namespace helloworld\Module;

use BEAR\Framework\Module\FrameworkModule;

use BEAR\Framework;
use Ray\Di\AbstractModule;

/**
 * Application module
 *
 * @package    helloworld
 * @subpackage Module
 */
class AppModule extends AbstractModule
{
    /**
     * (non-PHPdoc)
     * @see Ray\Di.AbstractModule::configure()
     */
    protected function configure()
    {
        $config = require __DIR__ . '/config.php';
        $this->install(new Framework\Module\NamedModule($config));
        $this->install(new FrameworkModule($this));
        $this->install(new Framework\Module\SchemeModule( __NAMESPACE__ . '\SchemeCollectionProvider'));
    }
}
