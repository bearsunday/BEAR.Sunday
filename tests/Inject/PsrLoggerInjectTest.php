<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Inject;

use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class PsrLoggerInjectTest extends TestCase
{
    public function testInjectTrait()
    {
        $app = (new Injector(new PsrLoggerModule))->getInstance(__NAMESPACE__ . '\PsrLoggerApplication');
        $this->assertInstanceOf('\BEAR\Sunday\Inject\DummyLogger', $app->returnDependency());
    }
}
