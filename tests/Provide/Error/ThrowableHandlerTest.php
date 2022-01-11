<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Error;

use BEAR\Resource\Exception\ResourceNotFoundException;
use BEAR\Sunday\Extension\Router\RouterMatch;
use BEAR\Sunday\Provide\Transfer\ConditionalResponse;
use BEAR\Sunday\Provide\Transfer\FakeHttpResponder;
use BEAR\Sunday\Provide\Transfer\Header;
use PHPUnit\Framework\TestCase;
use Throwable;

use function ini_set;

// phpcs:disable SlevomatCodingStandard.Exceptions.ReferenceThrowableOnly.ReferencedGeneralException
class ThrowableHandlerTest extends TestCase
{
    /** @var int */
    public static $code;

    private \BEAR\Sunday\Provide\Error\ThrowableHandler $throableHandler;

    protected function setUp(): void
    {
        FakeHttpResponder::reset();
        $this->throableHandler = new ThrowableHandler(new VndError(new FakeHttpResponder(new Header(), new ConditionalResponse())));
        ini_set('error_log', '/dev/null');
    }

    public function testException(): void
    {
        $e = new ResourceNotFoundException('', 404);
        $this->throableHandler->handle($e, new RouterMatch())->transfer();
        $this->assertSame(404, FakeHttpResponder::$code);
        $this->assertSame([['Content-Type: application/vnd.error+json', false]], FakeHttpResponder::$headers);
        $this->assertSame('{"message":"Not Found"}', FakeHttpResponder::$body);
    }

    public function testError(): void
    {
        $e = null;
        try {
            echo \HELLO; // @phpstan-ignore-line
        } catch (Throwable $e) {  // @phpstan-ignore-line create $e
        }

        $this->throableHandler->handle($e, new RouterMatch())->transfer(); // @phpstan-ignore-line
        $this->assertSame(500, FakeHttpResponder::$code);
        $this->assertSame([['Content-Type: application/vnd.error+json', false]], FakeHttpResponder::$headers);
        $this->assertSame('{"message":"500 Server Error"}', FakeHttpResponder::$body);
    }
}
