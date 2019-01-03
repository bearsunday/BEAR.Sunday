<?php

declare(strict_types=1);
/**
 * This file is part of the BEAR.Sunday package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Sunday\Fake\Resource\FakeResource;
use PHPUnit\Framework\TestCase;

class HttpResponderTest extends TestCase
{
    /**
     * @var FakeHttpResponder
     */
    private $responder;

    public function setUp()
    {
        parent::setUp();
        $this->responder = new FakeHttpResponder;
        FakeHttpResponder::reset();
    }

    public function testTransfer()
    {
        $ro = (new FakeResource)->onGet();
        $ro->transfer($this->responder, []);
        $expectedArgs = [
            ['Cache-Control: max-age=0', false],
            ['content-type: application/json', false],
        ];
        $this->assertSame($expectedArgs, FakeHttpResponder::$headers);
        $expect = '{"greeting":"hello world"}';
        $actual = FakeHttpResponder::$body;
        $this->assertSame($expect, $actual);
    }

    public function testTransferToStringInHeader()
    {
        $ro = (new FakeResource)->onGet();
        $ro->headers['Foo'] = new class {
            public function __toString()
            {
                return 'foo-string';
            }
        };
        $ro->transfer($this->responder, []);
        $expectedArgs = [
            ['Cache-Control: max-age=0', false],
            ['Foo: foo-string', false],
            ['content-type: application/json', false],
        ];
        $this->assertSame($expectedArgs, FakeHttpResponder::$headers);
        $expect = '{"greeting":"hello world"}';
        $actual = FakeHttpResponder::$body;
        $this->assertSame($expect, $actual);
    }

    public function testTransferETagIsMatch()
    {
        $ro = (new FakeResource)->onGet();
        $ro->headers['ETag'] = 'etag-x';
        $ro->transfer($this->responder, ['HTTP_IF_NONE_MATCH' => 'etag-x']);
        $expectedArgs = [
            ['Cache-Control: max-age=0', false],
            ['ETag: etag-x', false],
        ];
        $this->assertSame($expectedArgs, FakeHttpResponder::$headers);
        $expect = null;
        $actual = FakeHttpResponder::$body;
        $this->assertSame($expect, $actual);
        $this->assertSame(304, FakeHttpResponder::$code);
    }

    public function testTransferETagIsNotMatch()
    {
        $ro = (new FakeResource)->onGet();
        $ro->headers['ETag'] = 'etag-y';
        $ro->transfer($this->responder, ['HTTP_IF_NONE_MATCH' => 'etag-x']);
        $expectedArgs = [
            ['Cache-Control: max-age=0', false],
            ['ETag: etag-y', false],
            ['content-type: application/json', false],
        ];
;
        $this->assertSame($expectedArgs, FakeHttpResponder::$headers);
        $expect = '{"greeting":"hello world"}';
        $actual = FakeHttpResponder::$body;
        $this->assertSame($expect, $actual);
        $this->assertSame(200, FakeHttpResponder::$code);
    }
}
