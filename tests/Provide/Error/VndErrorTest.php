<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Error;

use BEAR\Resource\Exception\BadRequestException;
use BEAR\Resource\Exception\ResourceNotFoundException;
use BEAR\Resource\Exception\ServerErrorException;
use BEAR\Sunday\Extension\Router\RouterMatch;
use BEAR\Sunday\Provide\Transfer\ConditionalResponse;
use BEAR\Sunday\Provide\Transfer\FakeHttpResponder;
use BEAR\Sunday\Provide\Transfer\Header;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function ini_set;

class VndErrorTest extends TestCase
{
    public static int $code;
    private VndError $vndError;

    protected function setUp(): void
    {
        FakeHttpResponder::reset();
        $this->vndError = new VndError(new FakeHttpResponder(new Header(), new ConditionalResponse()));
        ini_set('error_log', '/dev/null');
    }

    public function testNotFound(): void
    {
        $e = new ResourceNotFoundException('', 404);
        $this->vndError->handle($e, new RouterMatch())->transfer();
        $this->assertSame(404, FakeHttpResponder::$code);
        $this->assertSame([['Content-Type: application/vnd.error+json', false]], FakeHttpResponder::$headers);
        $this->assertSame('{"message":"Not Found"}', FakeHttpResponder::$body);
    }

    public function testBadRequest(): void
    {
        $e = new BadRequestException('invalid-method', 400);
        $this->vndError->handle($e, new RouterMatch())->transfer();
        $this->assertSame(400, FakeHttpResponder::$code);
        $this->assertSame('{"message":"Bad Request"}', FakeHttpResponder::$body);
    }

    public function testServerError(): void
    {
        $e = new ServerErrorException('message', 501);
        $this->vndError->handle($e, new RouterMatch())->transfer();
        $this->assertSame(501, FakeHttpResponder::$code);
        $this->assertSame('{"message":"Not Implemented"}', FakeHttpResponder::$body);
    }

    public function testRuntimeError(): void
    {
        $e = new RuntimeException('message', 0);
        $this->vndError->handle($e, new RouterMatch())->transfer();
        $this->assertSame(500, FakeHttpResponder::$code);
        $this->assertSame('{"message":"500 Server Error"}', FakeHttpResponder::$body);
    }

    public function testServerErrorNot50X(): void
    {
        $e = new ServerErrorException('message', 0);
        $this->vndError->handle($e, new RouterMatch())->transfer();
        $this->assertSame(500, FakeHttpResponder::$code);
        $this->assertSame('{"message":"500 Server Error"}', FakeHttpResponder::$body);
    }
}
