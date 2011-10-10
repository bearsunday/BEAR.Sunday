<?php
namespace BEAR\Framework\HelloWorld;
use BEAR\ResourceObject\Page as PageResource;

class HelloWorld extends PageResource
{
    public function onGet()
    {
        $this->set('greetings', 'Hello World !');
    }
}
