<?php

namespace restWorld\ResourceObject\RestBucks;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject,
    BEAR\Resource\Resource,
    BEAR\Resource\Uri;

/**
 * Order
 *
 * @Scope("singleton")
 */
class Order extends AbstractObject
{

    private $orders = [];
    
    private $ordersIds = ['latte' => 801, 'coffee' => 908];

    /**
     * @param Resource $resource
     */
    public function __construct()
    {
    }

    public function onGet($id)
    {
        return $this->orders[$id];
    }

    /**
     * Post
     *
     * @param string $drink
     */
    public function onPost($drink)
    {
        // data store here
        // and get order id.
        $orderId = $this->ordersIds[$drink];
        $this->orders[$orderId] = $drink;
        // created
        $this->code = 201;
        $this->headers['Location'] = "app://self/RestBucks/Order/?id=$orderId";
        $this->headers['rel=payment'] = new Uri('app://self/RestBucks/Payment', array('order_id' => $orderId));
        return $this;
    }
}