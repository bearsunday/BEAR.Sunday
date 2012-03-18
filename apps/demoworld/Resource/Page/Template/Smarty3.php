<?php
namespace demoworld\Resource\Page\template;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Resource\Resource,
    BEAR\Framework\Link\View\Smarty3 as SmartyView;

// require dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/vendor/smarty/smarty/libs/Smarty.class.php';

class Smarty3 extends Page
{
    use SmartyView;

    public function __construct()
    {
    }

    public function __wakeup()
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
