<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Transfer\TransferInterface;

class HttpResponder implements TransferInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ResourceObject $resourceObject, array $server)
    {
        unset($server);
        // render
        $body = $resourceObject->toString();

        // code
        http_response_code($resourceObject->code);

        // header
        foreach ($resourceObject->headers as $label => $value) {
            header("{$label}: {$value}", false);
        }

        // body
        echo $body;
    }
}
