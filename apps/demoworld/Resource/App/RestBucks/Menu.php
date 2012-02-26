<?php
namespace demoworld\Resource\App\RestBucks;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject,
    BEAR\Resource\Resource,
    BEAR\Resource\Uri;

/**
 * Order
 *
 * @Scope("singleton")
 */
class Menu extends AbstractObject
{

    private $menu = [];

    /**
     * @param Resource $resource
     */
    public function __construct()
    {
        $this->menu = ['coffee' => 300, 'latte' => 400];
    }

    public function onGet($drink = null)
    {
        if ($drink === null) {
            $this->body = $this->menu;
            return $this;
        }
        $this->headers['rel=order'] = new Uri('app://self/RestBucks/Order', ['drink' => $drink]);
        $this->body['drink'] = $drink;
        $this->body['price'] = $this->menu[$drink];
        return $this;
    }
}