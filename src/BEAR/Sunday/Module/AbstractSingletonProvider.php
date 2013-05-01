<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module;

use Ray\Di\ProviderInterface as Provide;

/**
 * Singleton provider
 *
 *
 * @Scope("prototype")
 */
abstract class AbstractSingletonProvider implements Provide
{
    /**
     * Instance
     *
     * @var object
     */
    private $instance;

    /**
     * Return singleton instance
     *
     * @return object
     */
    public function get()
    {
        if ($this->instance === null) {
            $this->instance = $this->newInstance();
        }

        return $this->instance;
    }

    /**
     * New instance
     *
     * @return object
     */
    abstract public function newInstance();
}
