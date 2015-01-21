<?php

namespace BEAR\Sunday\Provide\Error;


function http_response_code($int) {
    FakeVndError::$code = func_get_args();
}
