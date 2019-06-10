<?php

declare(strict_types=1);

namespace MyVendor\HelloWorld\Resource\Page;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    public function onGet(string $name = 'World') : ResourceObject
    {
        $this->body['greeting'] = 'Hello ' . $name;

        return $this;
    }
}
