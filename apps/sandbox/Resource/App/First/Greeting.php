<?php
/**
 * App resource
 *
 * @package    Sandbox
 * @subpackage resource
 */
namespace Sandbox\Resource\App\First;

use BEAR\Resource\AbstractObject;

/**
 * Greeting resource
 */
class Greeting extends AbstractObject
{
    /**
     * Get
     *
     * @param string $name
     *
     * @return string
     */
    public function onGet($name)
    {
        return "Hello, {$name}";
    }
}
