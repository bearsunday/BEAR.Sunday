<?php

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Sunday\Fake\Resource\FakeResource;

class JsonResponderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HttpResponder
     */
    private $responder;

    public function setUp()
    {
        parent::setUp();
        $this->responder = new FakeJsonResponder;
        FakeHttpResponder::reset();
    }

    public function testTransfer()
    {
        $ro = (new FakeResource)->onGet();
        $ro->transfer($this->responder);
        $expect = '{"greeting":"hello world"}';
        $actual = FakeJsonResponder::$content;
        $this->assertSame($expect, $actual);
    }

    public function testRfc4627()
    {
        $ro = (new FakeResource)->onGet();
        $ro->transfer($this->responder);
        $expectedArgs = 'Content-Type: application/json; charset=utf-8';
        $this->assertEquals($expectedArgs, FakeHttpResponder::$headers[1][0]);

    }
}
