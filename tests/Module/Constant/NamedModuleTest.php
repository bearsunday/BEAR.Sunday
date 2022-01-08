<?php

declare(strict_types=1);

namespace BEAR\Sunday\Module\Constant;

use BEAR\Sunday\FakeApplication;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

use function assert;

class NamedModuleTest extends TestCase
{
    private \BEAR\Sunday\FakeApplication $app;

    protected function setUp(): void
    {
        $names = [
            'path' => __DIR__,
            'id' => 'bear',
        ];
        $app = (new Injector(new NamedModule($names)))->getInstance(FakeApplication::class);
        assert($app instanceof FakeApplication);
        $this->app = $app;
    }

    public function testNamed(): void
    {
        $this->assertSame(__DIR__, $this->app->dir);
        $this->assertSame('bear', $this->app->id);
    }
}
