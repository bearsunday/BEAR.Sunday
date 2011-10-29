<?php
namespace BEAR\Framework\HelloWorld;
use BEAR\ResourceObject\Page;

class HelloWorld extends Page
{
    public function onGet()
    {
        $this->set('greetings', 'Hello World !');
    }
}