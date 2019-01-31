<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Provide\Error;

use BEAR\Sunday\Extension\Error\NullError;
use BEAR\Sunday\Extension\Router\RouterMatch;
use PHPUnit\Framework\TestCase;

class NullErrorTest extends TestCase
{
    public function testNullError()
    {
        (new NullError)->handle(new \Exception, new RouterMatch)->transfer();
        $this->expectNotToPerformAssertions();
    }
}
