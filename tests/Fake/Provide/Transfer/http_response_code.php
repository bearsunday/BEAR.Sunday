<?php

namespace BEAR\Sunday\Provide\Transfer;

function http_response_code($int)
{
    FakeHttpResponder::$code = func_get_args();
}
