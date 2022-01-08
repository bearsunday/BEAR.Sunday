<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Router;

use BEAR\Sunday\Exception\BadRequestJsonException;
use PHPUnit\Framework\TestCase;

class WebRouterTest extends TestCase
{
    private \BEAR\Sunday\Provide\Router\WebRouter $router;

    protected function setUp(): void
    {
        parent::setUp();
        $this->router = new WebRouter('page://self');
    }

    public function testMatchRoot(): void
    {
        $global = [
            '_GET' => [],
            '_POST' => [],
        ];
        $server = [
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/',
        ];
        $request = $this->router->match($global, $server);
        $this->assertSame('get', $request->method);
        $this->assertSame('page://self/', $request->path);
        $this->assertSame([], $request->query);
    }

    public function testMatchWithQuery(): void
    {
        $global = [
            '_GET' => ['id' => '1'],
            '_POST' => [],
        ];
        $server = [
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/?id=1',
        ];
        $request = $this->router->match($global, $server);
        $this->assertSame('get', $request->method);
        $this->assertSame('page://self/', $request->path);
        $this->assertSame(['id' => '1'], $request->query);
    }

    public function testPost(): void
    {
        $global = [
            '_GET' => [],
            '_POST' => ['solstice' => 'eclipse'],
        ];
        $server = [
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI' => '/',
        ];
        $request = $this->router->match($global, $server);
        $this->assertSame('post', $request->method);
        $this->assertSame('page://self/', $request->path);
        $this->assertSame(['solstice' => 'eclipse'], $request->query);
    }

    public function testPutFormUrlEncoded(): void
    {
        $global = [
            '_GET' => [],
            '_POST' => [],
        ];
        $server = [
            'REQUEST_METHOD' => 'PUT',
            'REQUEST_URI' => '/',
            'CONTENT_TYPE' => 'application/x-www-form-urlencoded',
            'HTTP_RAW_POST_DATA' => 'solstice=eclipse',
        ];
        $request = $this->router->match($global, $server);
        $this->assertSame('put', $request->method);
        $this->assertSame('page://self/', $request->path);
        $this->assertSame(['solstice' => 'eclipse'], $request->query);
    }

    public function testPutApplicationJson(): void
    {
        $global = [
            '_GET' => [],
            '_POST' => [],
        ];
        $server = [
            'REQUEST_METHOD' => 'PUT',
            'REQUEST_URI' => '/',
            'CONTENT_TYPE' => 'application/json',
            'HTTP_RAW_POST_DATA' => '{"solstice":"eclipse"}',
        ];
        $request = $this->router->match($global, $server);
        $this->assertSame('put', $request->method);
        $this->assertSame('page://self/', $request->path);
        $this->assertSame(['solstice' => 'eclipse'], $request->query);
    }

    public function testPutUnknowMediaType(): void
    {
        $global = [
            '_GET' => [],
            '_POST' => [],
        ];
        $server = [
            'REQUEST_METHOD' => 'PUT',
            'REQUEST_URI' => '/',
            'CONTENT_TYPE' => 'application/__unknown__',
            'HTTP_RAW_POST_DATA' => '{"solstice":"eclipse"}',
        ];
        $request = $this->router->match($global, $server);
        $this->assertSame('put', $request->method);
        $this->assertSame('page://self/', $request->path);
        $this->assertSame([], $request->query);
    }

    public function testPutInvalidJson(): void
    {
        $this->expectException(BadRequestJsonException::class);
        $this->expectExceptionMessage('Syntax error');
        $global = [
            '_GET' => [],
            '_POST' => [],
        ];
        $server = [
            'REQUEST_METHOD' => 'PUT',
            'REQUEST_URI' => '/',
            'CONTENT_TYPE' => 'application/json',
            'HTTP_RAW_POST_DATA' => '{"solstice"}',
        ];
        $request = $this->router->match($global, $server);
    }

    public function testGenerate(): void
    {
        $actual = (bool) $this->router->generate('', []);
        $this->assertFalse($actual);
    }
}
