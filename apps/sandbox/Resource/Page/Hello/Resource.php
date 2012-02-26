<?php
namespace sandbox\Resource\Page\Hello;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page;
use BEAR\Framework\Link\View\Dev as DevView,
    BEAR\Framework\Link\View\Php as PhpView,
    BEAR\Framework\Inject\ResourceInject;

/**
 * Greeting page
 */
class Resource extends Page
{
    use PhpView;
    use ResourceInject;

    /**
     * @return ResourceObject
     */
    public function onGet()
    {
        $this['message'] = $this->resource->get->uri('app://self/greetings')->withQuery(['lang' => 'ja'])->request();
        return $this;
    }
}
