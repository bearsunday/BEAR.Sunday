<?php

namespace MyVendor\HelloWorld\Resource\Page;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    public function onGet($name = 'World')
    {
        $this->body['greeting'] = 'Hello ' . $name;

        return $this;
    }
}
