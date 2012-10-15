<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\WebContext;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Aura.Web Context module
 *
 * @package    BEAR.Sunday
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
            ->to('BEAR\Sunday\Module\Provider\WebContextProvider')
            ->in(Scope::SINGLETON);
    }
}
