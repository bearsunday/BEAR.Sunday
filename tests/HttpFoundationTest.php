<?php

namespace BEAR\Framework\Tests;

use BEAR\Framework\Web\HttpFoundation as Output;
use BEAR\Framework\Resource\Page\Ok;
/**
 * Test class for Annotation.
 */
class HttFoundationTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->output = new Output;
    }

    public function testNew()
    {
        $this->assertInstanceOf('BEAR\Framework\Web\HttpFoundation', $this->output);
    }

    public function test_Output()
    {
        $response = new Ok;
        $response->body = '';
        ob_start();
        $this->output->setResource($response)->send();
        $ob = ob_get_clean();
        $this->assertTrue(is_string($ob));
    }

    public function test_Prepare_Output()
    {
        $response = new Ok;
        $response->body = '';
        ob_start();
        $this->output->setResource($response)->prepare()->send();
        $ob = ob_get_clean();
        $this->assertTrue(is_string($ob));
    }

}
