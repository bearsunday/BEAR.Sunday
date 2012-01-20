<?php
namespace demoWorld\Page\HyperLink;

use BEAR\Resource\Object as ResourceObject,
BEAR\Resource\AbstractObject as Page,
BEAR\Resource\Resource,
BEAR\Framework\Link\View\Twig as TwigView;

/**
 * Simple HATEOAS
 *
 * @see http://www.infoq.com/articles/webber-rest-workflow "How to GET a Cup of Coffee"
 */
class RestBucks extends Page
{
    use TwigView;

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
        $order = $this->resource->post->uri($orderUri)->addQuery(array('drink' => $menu['drink']))->request();
        $this['order'] = $order;
        return $this;
    }
}
