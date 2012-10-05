<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Signal;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Signal module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class SignalModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('Aura\Signal\Manager')->toProvider('BEAR\Sunday\Module\Provider\SignalProvider')->in(Scope::SINGLETON);
    }
}
