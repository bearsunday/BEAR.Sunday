<?php
/**
 * BEAR.Resource
 *
 * @license  http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module;

trait Singleton
{
    /**
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
}