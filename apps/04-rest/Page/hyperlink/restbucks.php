<?php
namespace restWorld\Page\HyperLink;

use BEAR\Resource\Object as ResourceObject,
BEAR\Resource\AbstractObject as Page,
BEAR\Resource\Resource,
BEAR\Framework\Link\View\Haanga as HaangaView;

/**
 * Simple HATEOAS
 *
 */
class RestBucks extends Page
{
    use HaangaView;

    /**
     * @var ResourceObject
     */
    protected $greeting;

    /**
     * Resource
     *
     * @var Client
     */
    protected $resource;

    /**
     * @param Resource $resource Resource Client
     *
     * @Inject
     */
    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return ResourceObject
     */
    public function onGet($drink)
    {
        $menu = $this->resource->get->uri('app://self/RestBucks/Menu')->withQuery(array('drink' => $drink))->eager->request();
        $orderUri = $menu->headers['rel=order'];
        $this['order'] = $this->resource->post->uri($orderUri)->addQuery(array('drink' => $menu['drink']))->eager->request();
        return $this;
    }
}
