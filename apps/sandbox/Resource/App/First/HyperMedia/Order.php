<?php
namespace sandbox\Resource\App\First\HyperMedia;

use BEAR\Resource\AbstractObject;
use BEAR\Resource\Link;

/**
 * Greeting resource
 */
class Order extends AbstractObject
{
    public $links = [
        'payment' => [Link::HREF => 'app://self/first/hypermedia/payment{?id}', Link::TEMPLATED => true]
    ];

    /**
     * Post
     *
     * @param string $id
     *
     * @return array
     */
    public function onPost($item)
    {
        $this['item'] = $item;
        $this['id'] = date('is'); // min+sec

        return $this;
    }
}
