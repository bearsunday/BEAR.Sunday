<?php
/**
 * Module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
namespace BEAR\Framework\Module\WebContext;
use Ray\Di\Scope;

use BEAR\Framework\Module\StandardModule;
use Ray\Di\AbstractModule, Ray\Di\Injector;

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
        ->to('BEAR\Framework\Module\Provider\WebContextProvider')->in(Scope::SINGLETON);
    }
}
