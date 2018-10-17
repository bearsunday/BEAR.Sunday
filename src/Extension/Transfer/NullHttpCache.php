<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Transfer;

final class NullHttpCache implements HttpCacheInterface
{
    /**
     * {@inheritdoc}
     */
    public function isNotModified(array $server) : bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function transfer()
    {
    }
}
