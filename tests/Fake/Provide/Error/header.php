<?php

namespace BEAR\Sunday\Provide\Error;

function header(
    $string,
    $replace = true,
    $http_response_code = null
) {
    FakeVndError::$headers = func_get_args();
}
