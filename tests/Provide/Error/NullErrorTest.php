<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Error;

use BEAR\Sunday\Extension\Error\ErrorInterface;
use BEAR\Sunday\Extension\Error\NullError;
use BEAR\Sunday\Extension\Router\RouterMatch;
use Exception;
use PHPUnit\Framework\TestCase;

class NullErrorTest extends TestCase
{
    public function testNullError(): void
    {
        $error = (new NullError())->handle(new Exception(), new RouterMatch());
        $error->transfer();
        $this->assertInstanceOf(ErrorInterface::class, $error);
    }
}
