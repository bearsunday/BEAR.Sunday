<?php
namespace BEAR\Framework\HelloWorld\ResourceObject;

class HelloWorld extends ResourceObject
{
    public function onGet()
    {
        return 'Hello World !';
    }
}
