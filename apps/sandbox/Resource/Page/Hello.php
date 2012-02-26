<?php
namespace sandbox\Resource\Page;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page;
use BEAR\Framework\Link\View\Dev as DevView;
/**
 * Greeting page
 */
class Hello extends Page
{
    use DevView;

    /**
     * @return ResourceObject
     */
    public function onGet()
    {
        $this->body = 'Hello ';
        return $this;
    }
}
