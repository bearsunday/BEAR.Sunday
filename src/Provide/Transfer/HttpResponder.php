<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Transfer\TransferInterface;

class HttpResponder implements TransferInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ResourceObject $ro, array $server)
    {
        if ($this->respondeIfETagMatch($ro, $server)) {
            return;
        }

        unset($server);
        // render
        if (! $ro->view) {
            $ro->toString();
        }

        // header
        foreach ($ro->headers as $label => $value) {
            header("{$label}: {$value}", false);
        }

        // code
        http_response_code($ro->code);

        // body
        echo $ro->view;
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
