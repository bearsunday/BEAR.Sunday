<?php
namespace demoworld\Resource\Page\HyperLink;

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

    protected $menu;

    /**
     * @param Resource $resource Resource Client
     *
     * @Inject
     */
    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
        $this->menu = $resource->newInstance('app://self/RestBucks/Menu');
    }

    /**
     * @return self
     */
    public function onGet($drink)
    {
        $menu = $this->resource->get->object($this->menu)->withQuery(['drink' => $drink])->eager->request();
        $orderUri = $menu->headers['rel=order'];
        $order = $this->resource->post->uri($orderUri)->addQuery(['drink' => $menu['drink']])->request();
        $this['order'] = $order;
        return $this;
    }
}
