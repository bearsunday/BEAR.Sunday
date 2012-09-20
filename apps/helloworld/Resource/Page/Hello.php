<?php
namespace helloworld\Resource\Page;

use BEAR\Resource\AbstractObject as Page;

/**
 * Hello World
 */
class Hello extends Page
{
    /**
     * Get
     *
     * @param string $nam
     */
    public function onGet($name)
    {
        $this->body = 'Hello ' . $name;

        return $this;
    }
}
