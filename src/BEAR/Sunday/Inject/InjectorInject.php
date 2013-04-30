<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Ray\Di\InjectorInterface;

/**
 * Inject injector
 */
trait InjectorInject
{
    /**
     * Dependency injector
     *
     * @var InjectorInterface
     */
    private $injector;

    /**
     * Injector setter
     *
     * @param InjectorInterface $injector
     *
     * @Ray\Di\Di\Inject
     */
    public function setInjector(InjectorInterface $injector)
    {
        $this->injector = $injector;
    }
}
