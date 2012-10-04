<?php
namespace Sandbox\Resource\App\First\HyperMedia;

use BEAR\Resource\AbstractObject;

/**
 * Greeting resource
 */
class Payment extends AbstractObject
{
    public function onPut($card_no)
    {
        $this['card_no'] = $card_no;

        return $this;
    }
}
