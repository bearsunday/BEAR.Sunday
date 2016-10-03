<?php

/**
 * test header function is taken from Aura.Web
 *
 * @see https://github.com/auraphp/Aura.Web/blob/a1a4e45d14b21d40d716d341b78a050e1905cc05/tests/unit/src/FakeResponseSender.php
 */
namespace BEAR\Sunday\Provide\Transfer;

function header($string, $replace = true, $http_response_code = null)
{
    FakeHttpResponder::$headers[] = func_get_args();

    unset($string, $replace, $http_response_code);
}
