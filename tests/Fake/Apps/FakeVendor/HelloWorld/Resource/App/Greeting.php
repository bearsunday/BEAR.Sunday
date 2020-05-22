<?php

namespace FakeVendor\HelloWorld\Resource\App;

use BEAR\Resource\ResourceObject;

class Greeting extends ResourceObject
{
    public function onGet(): ResourceObject
    {
        $this->body['greeting'] = 'hello world';

        return $this;
    }
}
