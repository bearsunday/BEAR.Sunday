<?php
/**
 * App resource
 *
 * @package    sandbox
 * @subpackage resource
 */
namespace sandbox\Resource\App\First\Greeting;

use BEAR\Resource\AbstractObject;

/**
 * Greeting resource
 */
class Aop extends AbstractObject
{
    /**
     * Get
     *
     * @param string $name
     *
     * @return string
     */
    public function onGet($name = 'anonymous')
    {
        return "Hello, {$name}";
    }
}
