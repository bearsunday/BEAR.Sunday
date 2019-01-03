<?php

/**
 * test header function is taken from Aura.Web
 *
 * @see https://github.com/auraphp/Aura.Web/blob/a1a4e45d14b21d40d716d341b78a050e1905cc05/tests/unit/src/FakeResponseSender.php
 */
namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Transfer\TransferInterface;

class FakeHttpResponder implements TransferInterface
{
    public static $code;
    public static $headers = [];
    public static $body;

    public static function reset()
    {
        static::$headers = [];
        static::$body = null;
    }

    public function __invoke(ResourceObject $ro, array $server)
    {
        if ($this->respondeIfETagMatch($ro, $server)) {
            return;
        }

        // render
        if (! $ro->view) {
            self::$body = $ro->toString();
        }

        // header
        foreach ($ro->headers as $label => $value) {
            header("{$label}: {$value}", false);
        }

        // code
        http_response_code($ro->code);
    }

    private function respondeIfETagMatch(ResourceObject $ro, array $server) : bool
    {
        if (! isset($server['HTTP_IF_NONE_MATCH'])
            || ! isset($ro->headers['ETag'])
            || $server['HTTP_IF_NONE_MATCH'] !== $ro->headers['ETag']
        ) {
            return false;
        }

        // See: https://httpwg.org/specs/rfc7232.html#status.304
        $mustGenerateHeaders = [
            'Cache-Control',
            'Content-Location',
            'Date',
            'ETag',
            'Expires',
            'Vary',
        ];

        // header
        foreach ($ro->headers as $label => $value) {
            if (! in_array($label, $mustGenerateHeaders, true)) {
                continue;
            }

            header("{$label}: {$value}", false);
        }

        // code
        http_response_code(304);

        return true;
    }
}
