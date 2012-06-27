<?php
namespace helloworld\Resource\App;

use BEAR\Resource\AbstractObject as Page;

class Hello extends Page
{
    /**
     * Hello resource
     *
     * @return self
     */
    public function onGet($name)
    {
        $this['greeting'] = 'Hello ' . $name;
        $this['time'] = date('r');

        return $this;
    }
}
