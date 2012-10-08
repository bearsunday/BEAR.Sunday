<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module;

use Aura\Autoload\Exception;

use BEAR\Sunday\Framework\Framework;

use Ray\Di\Injector;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Application module
 *
 * @package    BEAR.Framework
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
        $this->bind('')->annotatedWith('is_prod')->toInstance(false);
        $this->install(new Log\ZfLogModule);
        $this->install(new Log\ApplicationLoggerModule);
        $injector = Injector::create([$this], false);
        $this->install(new Di\InjectorModule($injector));
        $this->install(new Code\AnnotationModule);
        $this->install(new Signal\SignalModule);
        $this->install(new Resource\ResourceModule($injector));
        $this->install(new ExceptionHandle\HandleModule);
        $this->install(new Output\WebResponseModule);
        $this->install(new Output\ConsoleModule);
        $this->install(new Http\GuzzleModule);
    }
}
