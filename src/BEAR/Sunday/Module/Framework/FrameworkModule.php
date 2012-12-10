<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Framework;

use BEAR\Sunday\Module;
use Ray\Di\Injector;
use Ray\Di\AbstractModule;


/**
 * Application module
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class FrameworkModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        // core
        $this->install(new Module\Framework\ConstantModule);
        $this->install(new Module\Di\InjectorModule);
        $this->install(new Module\Resource\ResourceModule);
        $this->install(new Module\Code\CachedAnnotationModule);
        // extension
        $this->install(new Module\Cache\ApcModule);
        $this->install(new Module\Log\ApplicationLoggerModule);
        $this->install(new Module\Output\ConsoleModule);
        $this->install(new Module\TemplateEngine\ProdRendererModule);
    }
}
