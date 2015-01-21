<?php

namespace BEAR\Sunday\Provide\Error;

use BEAR\Resource\Exception\BadRequestException;
use BEAR\Resource\Exception\ResourceNotFoundException;
use BEAR\Resource\Exception\ServerErrorException;
use BEAR\Sunday\Extension\Router\RouterMatch;

class VndErrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FakeVndError
     */
    private $vndError;

    public function setUp()
    {
        FakeVndError::reset();
        $this->vndError = new FakeVndError;
        ini_set('error_log', '/dev/null');
    }

    public function testNotFound()
    {
        $e = new ResourceNotFoundException('', 404);
        $this->vndError->handle($e, new RouterMatch)->transfer();
        $this->assertSame([404], FakeVndError::$code);
        $this->assertSame(['Content-Type: application/vnd.error+json'], FakeVndError::$headers);
        $this->assertSame('{"message":"Not Found"}', FakeVndError::$content);
    }

    public function testBadRequest()
    {
        $e = new BadRequestException('invalid-method', 400);
        $this->vndError->handle($e, new RouterMatch)->transfer();
        $this->assertSame([400], FakeVndError::$code);
        $this->assertSame('{"message":"Bad Request"}', FakeVndError::$content);
    }

    public function testServerError()
    {
        $e = new ServerErrorException('message', 501);
        $this->vndError->handle($e, new RouterMatch)->transfer();
        $this->assertSame([501], FakeVndError::$code);
        $this->assertSame('{"message":"Not Implemented"}', FakeVndError::$content);
    }

    public function testServerErrorNot50X()
    {
        $e = new \RuntimeException('message', 0);
        $this->vndError->handle($e, new RouterMatch)->transfer();
        $this->assertSame([500], FakeVndError::$code);
        $this->assertSame('{"message":"500 Server Error"}', FakeVndError::$content);
    }
}
