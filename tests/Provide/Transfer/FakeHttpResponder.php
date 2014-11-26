<?php

/**
 * test header function is taken from Aura.Web
 * @see https://github.com/auraphp/Aura.Web/blob/a1a4e45d14b21d40d716d341b78a050e1905cc05/tests/unit/src/FakeResponseSender.php
 */
namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;

function header(
    $string,
    $replace = true,
    $http_response_code = null
) {
    FakeHttpResponder::$headers[] = func_get_args();
}

class FakeHttpResponder extends HttpResponder
{
    public static $headers = [];
    public static $content;

    public static function reset()
    {
        static::$headers = [];
        static::$content = null;
    }
    public function __invoke(ResourceObject $resourceObject)
    {
        ob_start();
        parent::__invoke($resourceObject);
        $body =  ob_get_clean();
        self::$content = $body;
    }
}
