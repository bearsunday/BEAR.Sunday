<?php
/**
 * BEAR.Framework
 *
 * @license  http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module;

use Ray\Di\ProviderInterface as Provide;

/**
 * Singleton Provider
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
     * New instance
     *
     * @return object
     */
    abstract function newInstance();

    /**
     * @return object
     */
    public function get()
    {
        if ($this->instance === null) {
            $this->instance = $this->newInstance();
        }
        return $this->instance;
    }
}