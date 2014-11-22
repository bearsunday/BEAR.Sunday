<?php
namespace MyVendor\MyApp\Resource\App;

use BEAR\Resource\ResourceObject;

class Greeting extends ResourceObject
{
    /**
     * @param string $name
     */
    public function onGet($name = 'world')
    {
        $this['greeting'] = 'Hello {$name}';

        return $this;
    }
}
