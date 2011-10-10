<?php
namespace BEAR\Framework\HelloWorld;
use BEAR\ResourceObject\ResourceObject;

/**
 *
 * @Template("greeting.tpl")
 */
class HelloWorld extends ResourceObject
{
    public function onGet()
    {
        $this->set('greetings', 'Hello World !');
    }
}
