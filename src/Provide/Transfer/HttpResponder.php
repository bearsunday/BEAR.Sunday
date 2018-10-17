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
}
