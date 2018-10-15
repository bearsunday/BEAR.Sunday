<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Sunday\Extension\Transfer\HttpCacheInterface;

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
