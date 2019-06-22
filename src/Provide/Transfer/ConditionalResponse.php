<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;

final class ConditionalResponse implements ConditionalResponseInterface
{
    /**
     * @see https://tools.ietf.org/html/rfc7232#section-4.1
     */
    const HEADER_IN_304 = [
        'Cache-Control',
        'Content-Location',
        'Date',
        'ETag',
        'Expires',
        'Vary'
    ];

    /**
     * {@inheritdoc}
     */
    public function isModified(ResourceObject $ro, array $server) : bool
    {
        return ! (isset($server['HTTP_IF_NONE_MATCH'], $ro->headers['ETag']) && $server['HTTP_IF_NONE_MATCH'] === $ro->headers['ETag']);
    }

    /**
     * {@inheritdoc}
     */
    public function getOutput(array $originalHeaders) : Output
    {
        $headers = [];
        foreach ($originalHeaders as $label => $value) {
            if (! in_array($label, self::HEADER_IN_304, true)) {
                continue;
            }
            $headers[$label] = $value;
        }

        return new Output(304, $headers, '');
    }
}
