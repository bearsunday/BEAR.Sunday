<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Error;

use BEAR\Sunday\Extension\Error\NullError;
use BEAR\Sunday\Extension\Router\RouterMatch;
use PHPUnit\Framework\TestCase;

class NullErrorTest extends TestCase
{
    public function testNullError()
    {
        $this->assertNull((new NullError)->handle(new \Exception, new RouterMatch)->transfer());
    }
}
