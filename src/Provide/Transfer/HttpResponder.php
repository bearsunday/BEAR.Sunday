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
        if ($this->isNotModified($ro, $server)) {
            $this->transfer304($ro);

            return;
        }

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

    private function isNotModified(ResourceObject $ro, array $server) : bool
    {
        return (isset($server['HTTP_IF_NONE_MATCH'])
            && isset($ro->headers['ETag'])
            && $server['HTTP_IF_NONE_MATCH'] === $ro->headers['ETag']
        );
    }

    /**
     * @see https://httpwg.org/specs/rfc7232.html#status.304
     */
    private function transfer304(ResourceObject $ro)
    {
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
    }
}
