<?php
/**
 * Module
 *
 * @package    Sandbox
 * @subpackage Module
 */
namespace Sandbox\Module;

use BEAR\Framework\Module;
use BEAR\Framework\Module\NamedModule;

/**
 * Production module
 *
 * @package    Sandbox
 * @subpackage Module
 */
class TestModule extends ProdModule
{
    /**
     * Install config value
     */
    protected function installConstants()
    {
        $config = require __DIR__ . '/config.php';
        $config['master_db']['dbname'] = 'blogbeartest';
        $config['slave_db'] = $config['master_db'];
        $this->install(new NamedModule($config));
    }
}
