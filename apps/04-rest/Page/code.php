<?php
namespace helloWorld\Page;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Framework\Link\View\Php as PhpView;

/**
 * Code page default
 */
class Code extends Page
{
    use PhpView;

    public $code = 200;

    public function __construct()
    {
    }

    /**
     * @return ResourceObject
     */
    public function onGet()
    {
        $this->body = '';
        return $this;
    }
}