<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module;

use Ray\Di\ProviderInterface as Provide;

/**
 * Prototype Provider
 *
 * @package BEAR.Framework
 *
 * @Scope("prototype")
 */
abstract class AbstractPrototypeProvider implements Provide
{
    /**
     * Instance
     *
     * @var object
     */
    private $instance;

    /**
     * Create new instance
     *
     * @return object
     */
    abstract public function newInstance();

    /**
     * Return cloned instance
     *
     * @return object
     */
    public function get()
    {
        if ($this->instance === null) {
            $this->instance = $this->newInstance();
        }

        return clone $this->instance;
    }
}
