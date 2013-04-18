<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Ray\Di\InjectorInterface;

/**
 * Inject injector
 *
 * @package    BEAR.Sunday
 * @subpackage Inject
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
     * @param Di $injector
     *
     * @Ray\Di\Di\Inject
     */
    public function setInjector(InjectorInterface $injector)
    {
        $this->injector = $injector;
    }
}
