<?php
namespace demoworld\Page\template;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Resource\Resource,
    BEAR\Framework\Link\View\Smarty3 as SmartyView;


class Smarty3 extends Page
{
    use SmartyView;

    public function __construct()
    {
    }

    /**
     * @return ResourceObject
     */
    public function onGet()
    {
        $this['greeting'] = 'Hello Smarty3';
        return $this;
    }
}