<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module;

/**
 * Singleton trait
 */
trait Singleton
{
    /**
     * Return singleton instance
     *
     * @return object
     */
    public function get()
    {
        static $instance;

        if ($instance === null) {
            $instance = $this->newInstance();
        }

        return $instance;
    }

    /**
     * New instance
     *
     * @return mixed
     */
    abstract public function newInstance();
}
