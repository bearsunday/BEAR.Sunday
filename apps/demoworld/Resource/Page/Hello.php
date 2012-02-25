<?php
namespace demoworld\Resource\Page;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Framework\Link\View\Php as PhpView;

/**
 * Hello World - page resource only
 *
 */
class Hello extends Page
{
    use PhpView;

    public function __construct()
    {
    }

    /**
     * @return ResourceObject
     */
    public function onGet()
    {
        $this['greeting'] = 'Hello World';
        return $this;
    }
}
