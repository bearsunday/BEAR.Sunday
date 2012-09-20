<?php
namespace helloworld\Resource\Page;

use BEAR\Resource\AbstractObject as Page;

/**
 * Hello World (min)
 */
class MinHello extends Page
{
    public $body = 'Hello World';

    public function onGet()
    {
        return $this;
    }
}
