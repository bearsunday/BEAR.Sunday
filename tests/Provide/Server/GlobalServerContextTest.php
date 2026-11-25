<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Server;

use PHPUnit\Framework\TestCase;

class GlobalServerContextTest extends TestCase
{
    private GlobalServerContext $context;

    /** @var array<mixed> */
    private array $server;

    protected function setUp(): void
    {
        $this->server = $_SERVER;
        $this->context = new GlobalServerContext();
        $_SERVER['X_TEST_STRING'] = 'value';
        $_SERVER['X_TEST_INT'] = 1;
        $_SERVER['HTTP_X_TEST_HEADER'] = 'from-client';
    }

    protected function tearDown(): void
    {
        $_SERVER = $this->server;
    }

    public function testGetString(): void
    {
        $this->assertSame('value', $this->context->get('X_TEST_STRING'));
    }

    public function testGetMissing(): void
    {
        $this->assertNull($this->context->get('X_TEST_MISSING'));
    }

    public function testGetNonString(): void
    {
        $this->assertNull($this->context->get('X_TEST_INT'));
    }

    public function testRequestHeaderDoesNotStandInForServerKey(): void
    {
        $this->assertNull($this->context->get('X_TEST_HEADER'));
    }
}
