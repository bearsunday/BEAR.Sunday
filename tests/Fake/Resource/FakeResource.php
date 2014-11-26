<?php

namespace BEAR\Sunday\Fake\Resource;

use BEAR\Resource\ResourceObject;

class FakeResource extends ResourceObject
{
    public function onGet()
    {
        $this->headers['Cache-Control'] = 'max-age=0';
        $this['greeting'] = 'hello world';

        return $this;
    }
}
