<?php
namespace BEAR\Framework\HelloWorld\Ro;

use BEAR\Resource\Object as ResourceObjcet;

class Greeting implements ResourceObjcet
{
    public function onGet($lang)
    {
        /**
         * @Template
         * @Cache(time=30)
         */
        if ($lang === 'en') {
            return 'Hello World';
        }
        return 'こんにちは世界';
    }
}
