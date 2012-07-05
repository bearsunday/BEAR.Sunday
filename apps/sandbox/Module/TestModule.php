<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use BEAR\Framework\Module;
use Ray\Di\AbstractModule;
use BEAR\Framework\Module\Database;

/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class TestModule extends AbstractModule
{
    /**
     * Constructor
     *
     * @param string $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        parent::__construct();
    }

    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->install(new DevModule($this->app, 'test.config.php'));
    }
}
