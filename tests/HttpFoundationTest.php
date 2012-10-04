<?php

namespace BEAR\Sunday\Tests;

use BEAR\Sunday\Output\Console;

use BEAR\Sunday\Web\SymfonyResponse as Output;
use BEAR\Sunday\Resource\Page\Ok;
/**
 * Test class for Annotation.
 */
class HttFoundationTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->output = new Output(new Console);
    }

    public function testNew()
    {
        $this->assertInstanceOf('BEAR\Sunday\Web\SymfonyResponse', $this->output);
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
