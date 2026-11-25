<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Server;

use PHPUnit\Framework\TestCase;

class GlobalServerContextTest extends TestCase
{
    private GlobalServerContext $context;

    protected function setUp(): void
    {
        $this->context = new GlobalServerContext();
        $_SERVER['X_TEST_STRING'] = 'value';
        $_SERVER['X_TEST_INT'] = 1;
    }

    protected function tearDown(): void
    {
        unset($_SERVER['X_TEST_STRING'], $_SERVER['X_TEST_INT']);
    }

    public function testGetString(): void
    {
        $this->assertSame('value', $this->context->get('X_TEST_STRING'));
        $this->assertTrue($this->context->has('X_TEST_STRING'));
    }

    public function testGetMissing(): void
    {
        $this->assertNull($this->context->get('X_TEST_MISSING'));
        $this->assertFalse($this->context->has('X_TEST_MISSING'));
    }

    public function testGetNonString(): void
    {
        $this->assertNull($this->context->get('X_TEST_INT'));
    }
}
