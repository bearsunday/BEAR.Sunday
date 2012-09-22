<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\WebContext;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Aura.Web Context module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class AuraWebModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this
        ->bind('Ray\Di\ProviderInterface')
        ->annotatedWith('webContext')
        ->to('BEAR\Framework\Module\Provider\WebContextProvider')
        ->in(Scope::SINGLETON);
    }
}
