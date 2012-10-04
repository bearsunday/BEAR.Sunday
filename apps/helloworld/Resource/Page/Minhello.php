<?php
namespace Helloworld\Resource\Page;

use BEAR\Resource\AbstractObject as Page;

/**
 * Hello World - min
 */
class Minhello extends Page
{
    public $body = 'Hello World';

    /**
     * Get
     *
     * @return \Helloworld\Resource\Page\MinHello
     */
    public function onGet()
    {
        return $this;
    }
}
