<?php
namespace helloworld\Resource\Page;

use BEAR\Resource\AbstractObject as Page;

/**
 * Hello World - min
 */
class MinHello extends Page
{
    public $body = 'Hello World';

    /**
     * Get
     *
     * @return \helloworld\Resource\Page\MinHello
     */
    public function onGet()
    {
        return $this;
    }
}
