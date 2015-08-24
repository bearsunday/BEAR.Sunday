<?php

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Sunday\Fake\Resource\FakeResource;

class HttpResponderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HttpResponder
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
        $this->assertEquals($expectedArgs, FakeHttpResponder::$headers);
        $expect = '{"greeting":"hello world"}';
        $actual = FakeHttpResponder::$content;
        $this->assertSame($expect, $actual);
    }
}
