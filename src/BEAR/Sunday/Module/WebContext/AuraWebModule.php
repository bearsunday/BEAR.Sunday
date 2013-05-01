<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\WebContext;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Aura.Web context module
 */
class AuraWebModule extends AbstractModule
{
    protected function configure()
    {
        $this
            ->bind('Ray\Di\ProviderInterface')
            ->annotatedWith('webContext')
            ->to('BEAR\Sunday\Module\WebContext\WebContextProvider')
            ->in(Scope::SINGLETON);
    }
}
