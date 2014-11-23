<?php
namespace BEAR\Sunday\Resource\Page;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    /**
     * @param string $name
     */
    public function onGet($name = 'world')
    {
        $this['greeting'] = "Hello {$name}";

        return $this;
    }
}
