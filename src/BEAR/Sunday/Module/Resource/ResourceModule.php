<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\Scope;
use BEAR\Resource\Module\ResourceModule as BearResourceModule;

/**
 * Resource module
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class ResourceModule extends AbstractModule
{
    private $injector;

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->install(new BearResourceModule);
        $this->bind('BEAR\Resource\LoggerInterface')->toProvider(__NAMESPACE__ . '\ResourceLoggerProvider');
    }
}
