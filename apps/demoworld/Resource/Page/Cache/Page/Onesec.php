<?php
namespace demoworld\Resource\Page\Cache\Page;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as AbstractPage,
    BEAR\Framework\Link\View\Php as PhpView;

use BEAR\Framework\Annotation\Cache,
    BEAR\Framework\Annotation\CacheUpdate;

/**
 * 1 sec Cache page
 *
 */
class Onesec extends AbstractPage
{
    use PhpView;

    public function __construct()
    {
    }

    /**
     * @Cache(1)
     */
    public function onGet($name)
    {
        $this['greeting'] = "Hello {$name} " . microtime(true);
        return $this;
    }

    /**
     * @CacheUpdate({"name"})
     */
    public function onPut($name)
    {
        // chacnge resource here.

        // 204 = no content
        $this->code = 204;
        $this->body = '';
        return $this;
    }
}
