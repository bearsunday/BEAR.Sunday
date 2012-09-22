<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Log;

use Ray\Di\AbstractModule;

/**
 * Monolog module
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
        $this
        ->bind('Guzzle\Common\Log\LogAdapterInterface')
        ->toProvider('BEAR\Framework\Module\Log\MonologModule\MonologProvider');
    }
}
