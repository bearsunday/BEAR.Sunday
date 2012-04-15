<?php
/**
 * BEAR.Framework
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use Ray\Di\InjectorInterface as Di;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Inject setter trait
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
trait InjectorInject
{
    /**
     * Dependency injector
     *
     * @var Di
     */
    private $injector;

    /**
     * Injector setter
     *
     * @param Di $injector
     *
     * @Inject
     */
    public function setInjector(Di $injector)
    {
        $this->injector = $injector;
    }
}
