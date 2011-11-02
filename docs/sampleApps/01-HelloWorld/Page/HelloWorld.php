<?php
namespace BEAR\App\HelloWorld;

use BEAR\Resource\ResourceObject\AbstractPage as Page;

class HelloWorld extends Page
{
    public function __construct()
    {
    }
    
    public function onGet()
    {
        $this->set('greetings', 'Hello World !');
    }
}