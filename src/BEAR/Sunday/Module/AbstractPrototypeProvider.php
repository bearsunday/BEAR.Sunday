<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module;

use Ray\Di\ProviderInterface as Provide;

/**
 * Prototype Provider
 *
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

    /**
     * Create new instance
     *
     * @return object
     */
    abstract public function newInstance();
}
