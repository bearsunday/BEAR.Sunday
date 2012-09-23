<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use BEAR\Framework\Module;
use BEAR\Framework\Module\NamedModule;

/**
 * Production module
 *
 * @package    sandbox
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
