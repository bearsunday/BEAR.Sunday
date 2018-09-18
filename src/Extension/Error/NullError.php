<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Extension\Error;

use BEAR\Sunday\Extension\Router\RouterMatch as Request;

final class NullError implements ErrorInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(\Exception $e, Request $request)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function transfer()
    {
    }
}
