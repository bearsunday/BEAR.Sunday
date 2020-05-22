<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Sunday\Fake\Resource\FakeResource;
use PHPUnit\Framework\TestCase;

class HttpResponderTest extends TestCase
{
    /**
     * @var FakeHttpResponder
     */
    private $responder;

    protected function setUp() : void
    {
        parent::setUp();
        $this->responder = new FakeHttpResponder(new Header, new ConditionalResponse);
        FakeHttpResponder::reset();
    }

    public function testTransfer() : void
    {
        $ro = (new FakeResource)->onGet();
        $ro->transfer($this->responder, []);
        $expectedArgs = [
            ['Cache-Control: max-age=0', false],
            ['Content-Type: application/json', false],
        ];
        $actual = FakeHttpResponder::$headers;
        $this->assertSame($expectedArgs, $actual);
        $expect = '{"greeting":"hello world"}';
        $actual = FakeHttpResponder::$body;
        $this->assertSame($expect, $actual);
    }

    public function testTransferToStringInHeader() : void
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
            ['Content-Type: application/json', false],
        ];
        $this->assertSame($expectedArgs, FakeHttpResponder::$headers);
        $expect = '{"greeting":"hello world"}';
        $actual = FakeHttpResponder::$body;
        $this->assertSame($expect, $actual);
    }

    public function testTransferETagIsMatch() : void
    {
        $ro = (new FakeResource)->onGet();
        $ro->headers['ETag'] = 'etag-x';
        $ro->transfer($this->responder, ['HTTP_IF_NONE_MATCH' => 'etag-x']);
        $expectedArgs = [
            ['Cache-Control: max-age=0', false],
            ['ETag: etag-x', false],
        ];
        $this->assertSame($expectedArgs, FakeHttpResponder::$headers);
        $expect = '';
        $actual = FakeHttpResponder::$body;
        $this->assertSame($expect, $actual);
        $this->assertSame(304, FakeHttpResponder::$code);
    }

    public function testTransferETagIsNotMatch() : void
    {
        $ro = (new FakeResource)->onGet();
        $ro->headers['ETag'] = 'etag-y';
        $ro->transfer($this->responder, ['HTTP_IF_NONE_MATCH' => 'etag-x']);
        $expectedArgs = [
            ['Cache-Control: max-age=0', false],
            ['ETag: etag-y', false],
            ['Content-Type: application/json', false],
        ];

        $this->assertSame($expectedArgs, FakeHttpResponder::$headers);
        $expect = '{"greeting":"hello world"}';
        $actual = FakeHttpResponder::$body;
        $this->assertSame($expect, $actual);
        $this->assertSame(200, FakeHttpResponder::$code);
    }

    public function testExcludeHeaderIn304() : void
    {
        $ro = (new FakeResource)->onGet();
        $ro->headers['ETag'] = 'etag-x';
        $ro->headers['X-Application'] = 'this-may-exclude-in-304';
        $ro->transfer($this->responder, ['HTTP_IF_NONE_MATCH' => 'etag-x']);
        $expectedArgs = [
            ['Cache-Control: max-age=0', false],
            ['ETag: etag-x', false],
        ];
        $this->assertSame($expectedArgs, FakeHttpResponder::$headers);
    }
}
