<?php
namespace helloWorld\Page;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page;

/**
 * Hello World - page resource only
 *
 */
class Hello extends Page
{
    public function __construct()
    {
    }

    /**
     * @return ResourceObject
     */
    public function onGet($name)
    {
        $this->body = 'Hello ' . $name;
        return $this;
    }
}
