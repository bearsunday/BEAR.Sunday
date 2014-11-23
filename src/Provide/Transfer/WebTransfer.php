<?php
/**
 * This file is part of the *** package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Transfer\TransferInterface;

class WebTransfer implements TransferInterface
{
    public function __invoke(ResourceObject $resourceObject)
    {
        // code
        http_response_code($resourceObject->code);
        // header
        foreach ($resourceObject->headers as $header) {
            header($header);
        }
        // body
        echo (string) $resourceObject;
    }
}
