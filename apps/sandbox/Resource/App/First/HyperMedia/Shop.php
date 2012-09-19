<?php
namespace sandbox\Resource\App\First\HyperMedia;

use BEAR\Resource\AbstractObject;
use BEAR\Framework\Inject\ResourceInject;
use BEAR\Framework\Inject\AInject;
/**
 * Greeting resource
 */
class Shop extends AbstractObject
{
    use ResourceInject;
    use AInject;

    /**
     * @param string $item
     *
     * @return array
     */
    public function onPost($item, $card_no)
    {
        $order = $this
        ->resource
        ->post
        ->uri('app://self/first/hypermedia/order')
        ->withQuery(['item' => $item])
        ->eager
        ->request();

        $payment = $this->a->href('payment', $order);

        $this
        ->resource
        ->put
        ->uri($payment)
        ->withQuery(['card_no' => $card_no])
        ->request();

        $this->code = 204;

        return $this;
    }
}
