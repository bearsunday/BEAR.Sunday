<?php

namespace MyVendor\HelloWorld\Resource\Page;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    public function onGet()
    {
        $this->body['greeting'] = 'hello world';
        return $this;
    }
}
