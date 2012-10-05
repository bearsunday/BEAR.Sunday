<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Di;

use BEAR\Sunday\Framework\Framework;

use Ray\Di\Injector;
use Ray\Di\InjectorInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Application module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class InjectorModule extends AbstractModule
{
    private $injector;

    /**
     * Constructor
     *
     * @param InjectorInterfacce $injector
     */
    public function __construct(InjectorInterface $injector)
    {
        $this->injector = $injector;
        //$logger = $this->requestInjection('BEAR\Sunday\Inject\Logger\Adapter');
        //$this->injector->setLogger($logger);
        parent::__construct();
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $config = $this->injector->getContainer()->getForge()->getConfig();
        $this->bind('Aura\Di\ConfigInterface')->toInstance($config);
        $this->bind('Ray\Di\InjectorInterface')->toInstance($this->injector);
    }
}
