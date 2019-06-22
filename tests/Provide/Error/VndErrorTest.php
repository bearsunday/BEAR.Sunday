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

class VndErrorTest extends TestCase
{
    public static $code;

    /**
     * @var VndError
     */
    private $vndError;

    protected function setUp() : void
    {
        FakeHttpResponder::reset();
        $this->vndError = new VndError(new FakeHttpResponder(new Header, new ConditionalResponse));
        ini_set('error_log', '/dev/null');
    }

    public function testNotFound()
    {
        $e = new ResourceNotFoundException('', 404);
        $this->vndError->handle($e, new RouterMatch)->transfer();
        $this->assertSame(404, FakeHttpResponder::$code);
        $this->assertSame([['Content-Type: application/vnd.error+json', false]], FakeHttpResponder::$headers);
        $this->assertSame('{"message":"Not Found"}', FakeHttpResponder::$body);
    }

    public function testBadRequest()
    {
        $e = new BadRequestException('invalid-method', 400);
        $this->vndError->handle($e, new RouterMatch)->transfer();
        $this->assertSame(400, FakeHttpResponder::$code);
        $this->assertSame('{"message":"Bad Request"}', FakeHttpResponder::$body);
    }

    public function testServerError()
    {
        $e = new ServerErrorException('message', 501);
        $this->vndError->handle($e, new RouterMatch)->transfer();
        $this->assertSame(501, FakeHttpResponder::$code);
        $this->assertSame('{"message":"Not Implemented"}', FakeHttpResponder::$body);
    }

    public function testRuntimeError()
    {
        $e = new \RuntimeException('message', 0);
        $this->vndError->handle($e, new RouterMatch)->transfer();
        $this->assertSame(500, FakeHttpResponder::$code);
        $this->assertSame('{"message":"500 Server Error"}', FakeHttpResponder::$body);
    }

    public function testServerErrorNot50X()
    {
        $e = new ServerErrorException('message', 0);
        $this->vndError->handle($e, new RouterMatch)->transfer();
        $this->assertSame(500, FakeHttpResponder::$code);
        $this->assertSame('{"message":"500 Server Error"}', FakeHttpResponder::$body);
    }
}
