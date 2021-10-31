<?php

declare(strict_types=1);

namespace BEAR\Sunday\Inject;

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Ray\Di\Injector;

class PsrLoggerInjectTest extends TestCase
{
    public function testInjectTrait(): void
    {
        $app = (new Injector(new PsrLoggerModule()))->getInstance(__NAMESPACE__ . '\PsrLoggerApplication');
        $this->assertInstanceOf(NullLogger::class, $app->returnDependency());
    }
}
