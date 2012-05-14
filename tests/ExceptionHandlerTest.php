<?php

namespace BEAR\Framework\Tests;

use BEAR\Framework\Exception\ExceptionHandler;
use BEAR\Framework\Web\HttpFoundation as Output;

class ExceptionHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->exceptionHandler = new ExceptionHandler;
        $this->exceptionHandler->setLogDir(__DIR__ . '/tmp');
        $output = new Output;
        $this->exceptionHandler->setResponse($output);
    }

    public function testNew()
    {
        $this->assertInstanceOf('BEAR\Framework\Exception\ExceptionHandler', $this->exceptionHandler);
    }

    public function testHandlerException()
    {
        $e = new \Exception;
        $response = $this->exceptionHandler->handle($e);
        $this->assertInstanceOf('BEAR\Framework\Resource\Page\Error', $response);
    }
}
