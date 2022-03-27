<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Sunday\Extension\Transfer\TransferInterface;
use Ray\Di\AbstractModule;

/**
 * Provides TransferInterface and derived bindings
 *
 * The following bindings are provided:
 *
 *  TransferInterface
 *  HeaderInterface
 *  ConditionalResponseInterface
 */
class HttpResponderModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(TransferInterface::class)->to(HttpResponder::class);
        $this->bind(HeaderInterface::class)->to(Header::class);
        $this->bind(ConditionalResponseInterface::class)->to(ConditionalResponse::class);
    }
}
