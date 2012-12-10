<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Di;

use Ray\Di\Injector;
use Ray\Di\InjectorInterface;
use Ray\Di\AbstractModule;


/**
 * Application module
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class InjectorModule extends AbstractModule
{
    private $injector;

    /**
     * Constructor
     *
     * @param InjectorInterface $injector
     */
    public function construct(InjectorInterface $injector)
    {
        $this->injector = $injector;
        $logger = $this->requestInjection('BEAR\Sunday\Inject\Logger\Adapter');
        $this->injector->setLogger($logger);
        parent::__construct();
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $config = $this->dependencyInjector->getContainer()->getForge()->getConfig();
        $this->bind('Aura\Di\ConfigInterface')->toInstance($config);
        $this->bind('Ray\Di\InjectorInterface')->toInstance($this->dependencyInjector);
        $module = $this->dependencyInjector->getModule();
        $this->bind('Ray\Di\AbstractModule')->toInstance($module);
    }
}
