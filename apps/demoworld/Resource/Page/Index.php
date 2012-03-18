<?php
namespace demoworld\Resource\Page;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Framework\Link\View\Php as PhpView;

/**
 * Hello World - page resource only
 *
 */
class Index extends Page
{
    use PhpView;

    public function __construct()
    {
    }

    /**
     * @return self
     */
    public function onGet()
    {
        $this['greeting'] = 'Hello Index !';
        return $this;
    }
}
