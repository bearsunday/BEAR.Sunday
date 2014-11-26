<?php
namespace BEAR\Sunday\Resource\App;

use BEAR\Resource\ResourceObject;

class Greeting extends ResourceObject
{
    /**
     * @param string $name
     */
    public function onGet($name)
    {
        $this['greeting'] = "Hello {$name}";

        return $this;
    }
}
