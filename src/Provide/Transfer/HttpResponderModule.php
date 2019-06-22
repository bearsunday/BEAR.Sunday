<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Sunday\Extension\Transfer\TransferInterface;
use Ray\Di\AbstractModule;

class HttpResponderModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(TransferInterface::class)->to(HttpResponder::class);
        $this->bind(HeaderInterface::class)->to(Header::class);
        $this->bind(ConditionalResponseInterface::class)->to(ConditionalResponse::class);
    }
}
