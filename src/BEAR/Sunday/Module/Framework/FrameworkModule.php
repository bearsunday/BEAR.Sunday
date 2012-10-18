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
        // install
        $this->install(new Module\Framework\ConstantModule);
        $this->install(new Module\Log\ZfLogModule);
        $this->install(new Module\Log\ApplicationLoggerModule);
        $injector = Injector::create([$this], on);
        $this->install(new Module\Di\InjectorModule($injector));
        $this->install(new Module\Code\AnnotationModule);
        $this->install(new Module\Signal\SignalModule);
        $this->install(new Module\Resource\ResourceModule($injector));
        $this->install(new Module\ExceptionHandle\HandleModule);
        $this->install(new Module\Output\WebResponseModule);
        $this->install(new Module\Output\ConsoleModule);
        $this->install(new Module\Http\GuzzleModule);
    }
}
