<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Di;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\InjectorInterface;


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
//    public function construct()
//    {
////        $this->injector = $injector;
////        $logger = $this->requestInjection('BEAR\Sunday\Inject\Logger\Adapter');
//        /** @var $logger \Ray\Di\LoggerInterface */
////        $this->injector->setLogger($logger);
//        parent::__construct();
//    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('Aura\Di\ConfigInterface')->to('Aura\Di\Config');
        $this->bind('Aura\ForgeInterface')->to('Aura\ForgeI');
        $this->bind('Aura\Di\ContainerInterface')->to('Ray\Di\Container');
        $this->bind('Aura\Di\ForgeInterface')->to('Ray\Di\Forge');
        $this->bind('Ray\Di\InjectorInterface')->to('Ray\Di\Injector');
        $this->bind('Ray\Di\AbstractModule')->toInstance($this);
    }
}
