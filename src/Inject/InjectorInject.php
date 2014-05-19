<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Ray\Di\InjectorInterface;

/**
 * Dependency injector setter
 */
trait InjectorInject
{
    /**
     * @var InjectorInterface
     */
    private $injector;

    /**
     * @param InjectorInterface $injector
     *
     * @Ray\Di\Di\Inject
     */
    public function setInjector(InjectorInterface $injector)
    {
        $this->injector = $injector;
    }
}
