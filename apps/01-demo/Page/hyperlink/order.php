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
class Order extends Page
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
        $order = $this->resource->post->uri('app://self/RestBucks/Order')->withQuery(['drink' => $drink])->eager->request();
        $paymentUri = $order->headers['rel=payment'];
        $payment = ['credit_card_number' => '123456789', 'expires' => '07/07', 'name' => 'John Citizen', 'amount' => '4.00'];
        $this['payment'] = $this->resource->put->uri($paymentUri)->addQuery($payment)->request();
        return $this;
    }
}
