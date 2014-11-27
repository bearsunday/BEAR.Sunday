<?php

namespace FakeVendor\HelloWorldX\Resource\App;

use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;

class Greeting extends ResourceObject
{
    private $resource;

    public function __construct(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @Embed(rel="hello_rel", src="app://hello/greeting")
     */
    public function onGet()
    {
        $this->body['greeting'] = 'hello world X';
        $this->body['hello'] = $this->resource->get->uri('app://hello/greeting')->eager->request()->body['greeting'];

        return $this;
    }
}
