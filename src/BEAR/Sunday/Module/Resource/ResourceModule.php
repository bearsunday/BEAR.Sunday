<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\Scope;
use BEAR\Resource\Module\ResourceModule as BearResourceModule;

/**
 * Resource module
 */
class ResourceModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\LoggerInterface')->toProvider(__NAMESPACE__ . '\ResourceLoggerProvider')->in(Scope::SINGLETON);
        $this->install(new BearResourceModule);
    }
}
