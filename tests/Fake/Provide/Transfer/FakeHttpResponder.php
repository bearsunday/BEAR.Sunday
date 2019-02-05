<?php

/**
 * test header function is taken from Aura.Web
 *
 * @see https://github.com/auraphp/Aura.Web/blob/a1a4e45d14b21d40d716d341b78a050e1905cc05/tests/unit/src/FakeResponseSender.php
 */
namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;

class FakeHttpResponder extends HttpResponder
{
    public static $code;
    public static $headers = [];
    public static $body;

    public static function reset()
    {
        static::$code = null;
        static::$headers = [];
        static::$body = null;
    }

    public function __invoke(ResourceObject $ro, array $server)
    {
        ob_start();
        parent::__invoke($ro, $server);
        self::$body = ob_get_clean();
    }
}
