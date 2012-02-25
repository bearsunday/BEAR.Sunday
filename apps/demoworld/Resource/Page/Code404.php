<?php
namespace demoworld\Resource\Page;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Framework\Link\View\Php as PhpView;

/**
 * 404
 */
class code404 extends Code
{
    use PhpView;

    public $code = 404;

    public function __construct()
    {
    }

    /**
     * @return ResourceObject
     */
    public function onGet()
    {
        return $this;
    }

}
