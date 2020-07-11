<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Error;

use BEAR\Sunday\Extension\Error\NullError;
use BEAR\Sunday\Extension\Router\RouterMatch;
use Exception;
use PHPUnit\Framework\TestCase;

class NullErrorTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testNullError(): void
    {
        (new NullError())->handle(new Exception(), new RouterMatch())->transfer();
    }
}
