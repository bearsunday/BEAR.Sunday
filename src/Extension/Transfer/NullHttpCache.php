<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
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
