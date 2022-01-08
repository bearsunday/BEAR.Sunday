<?php

declare(strict_types=1);

namespace BEAR\Sunday\Inject;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Ray\Di\Injector;

use function assert;

class PsrLoggerInjectTest extends TestCase
{
    public function testInjectTrait(): void
    {
        $app = (new Injector(new PsrLoggerModule()))->getInstance(__NAMESPACE__ . '\PsrLoggerApplication');
        assert($app instanceof PsrLoggerApplication);
        $this->assertInstanceOf(LoggerInterface::class, $app->returnDependency());
    }
}
