<?php
namespace demoworld\Resource\Page\Cache;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as AbstractPage,
    BEAR\Framework\Link\View\Php as PhpView;

use demoworld\Annotation\Cache,
    demoworld\Annotation\CacheUpdate;

/**
 * Cache page
 *
 */
class Page extends AbstractPage
{
    use PhpView;

    public function __construct()
    {
    }

    /**
     * @Cache(5)
     */
    public function onGet($name)
    {
        $this['greeting'] = "Hello {$name} " . time();
        return $this;
    }

    /**
     * CacheUpdate("name")
     */
    public function onUpdate($name)
    {
    }
}
