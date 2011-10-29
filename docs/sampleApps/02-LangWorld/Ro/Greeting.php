<?php
namespace BEAR\Framework\HelloWorld\Ro;

class Greeting extends ResourceObject
{
    public function onGet($lang)
    {
        if ($lang === 'en') {
            return 'Hello World';
        }
        return 'こんにちは世界';
    }
}
