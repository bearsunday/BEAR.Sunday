<?php
namespace BEAR\App\HelloWorld;

use BEAR\Resource\ResourceObject\Page;

class HelloWorld extends Page
{
    public function onGet()
    {
        $this->set('greetings', 'Hello World !');
    }
}