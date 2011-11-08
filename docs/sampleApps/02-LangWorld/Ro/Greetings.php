<?php
namespace BEAR\Framework\HelloWorld\Ro;

use BEAR\Resource\Object as Ro;

class Greeting implements Ro
{
    /**
     * @Cache(time=30)
     */
    public function onGet($lang)
    {
        $this['en'] = 'Hello World';
        $this['ja'] = 'こんにちは世界';
        return $this;
    }
}
