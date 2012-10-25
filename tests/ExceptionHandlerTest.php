<?php

namespace BEAR\Sunday\Tests;

use BEAR\Sunday\Output\Console;

use BEAR\Sunday\Exception\ExceptionHandler;
use BEAR\Sunday\Web\SymfonyResponse as Response;

class ExceptionHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->exceptionHandler = new ExceptionHandler;
        $this->exceptionHandler->setLogDir(__DIR__ . '/tmp');
    }

    public function testNew()
    {
        $this->assertInstanceOf('BEAR\Sunday\Exception\ExceptionHandler', $this->exceptionHandler);
    }

    public function testHandlerException()
    {
        $e = new \Exception;
        $response = $this->exceptionHandler->handle($e);
        $this->assertInstanceOf('BEAR\Sunday\Resource\Page\Error', $response);
    }
}
