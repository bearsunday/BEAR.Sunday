<?php
namespace sandbox\Resource\App\First\Greeting;

use BEAR\Resource\AbstractObject;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Greeting resource
 */
class Aop extends AbstractObject
{
    /**
     * Get
     *
     * @param  string $name
     *
     * @return string
     *
     */
    public function onGet($name = 'anonymous')
    {
        return "Hello, {$name}";
    }
}
