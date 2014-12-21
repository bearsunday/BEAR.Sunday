<?php

namespace BEAR\Sunday\Provide\Error;

use BEAR\Resource\Exception\BadRequestException;
use BEAR\Resource\Exception\ResourceNotFoundException;
use BEAR\Resource\Exception\ServerErrorException;
use BEAR\Sunday\Extension\Router\RouterMatch;

class VndErrorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        ini_set('error_log', '/dev/null');
    }

    public function testNotFound()
    {
        $error = new VndError;
        $e = new ResourceNotFoundException('', 404);
        $errorPage = $error->handle($e, new RouterMatch);
        $this->assertSame(404, $errorPage->code);
    }

    public function testBadRequest()
    {
        $error = new VndError;
        $e = new BadRequestException('invalid-method', 400);
        $errorPage = $error->handle($e, new RouterMatch);
        $this->assertSame(400, $errorPage->code);
    }

    public function testServerError()
    {
        $error = new VndError;
        $e = new ServerErrorException('message', 501);
        $errorPage = $error->handle($e, new RouterMatch);
        $this->assertSame(501, $errorPage->code);
    }

    public function testServerErrorNot50X()
    {
        $error = new VndError;
        $e = new \RuntimeException('message', 0);
        $errorPage = $error->handle($e, new RouterMatch);
        $this->assertSame(500, $errorPage->code);
    }
}
