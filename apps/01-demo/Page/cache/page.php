<?php
namespace demoWorld\Page\Cache;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as AbstractPage,
    BEAR\Framework\Link\View\Php as PhpView;

/**
 * Hello World - page resource only
 *
 * @Aspect
 */
class Page extends AbstractPage
{
    use PhpView;

    public function __construct()
    {
    }

    /**
     * @return ResourceObject
     *
     * @Cacheable
     */
    public function onGet($name)
    {
        $this['greeting'] = "Hello {$name} " . time();
        return $this;
    }

    /**
     * CachePush
     */
    public function onUpdate($name)
    {
    }
}
