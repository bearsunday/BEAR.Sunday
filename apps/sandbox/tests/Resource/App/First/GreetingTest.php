<?php
namespace sandbox\tests\Resource\App\Blog;

use sandbox\App;

class GreetingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Resource client
     *
     * @var BEAR\Resource\Resourcce
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $app = App::factory(App::RUN_MODE_TEST, true);
        $this->resource = $app->resource;
    }

    /**
     * resource
     *
     * @test
     */
    public function resource()
    {
        // resource request
        $resource = $this->resource->get->uri('app://self/first/greeting')->withQuery(['name' => 'BEAR'])->eager->request();
        $this->assertSame(200, $resource->code);

        return $resource;
    }

    /**
     * Type ?
     *
     * @depends resource
     * @test
     */
    public function type($resource)
    {
        $this->assertInternalType('string', $resource->body);
    }

    /**
     * Renderable ?
     *
     * @depends resource
     * test
     */
    public function render($resource)
    {
        $html = (string) $resource;
        $this->assertInternalType('string', $html);
    }

    /**
     * @depends resource
     * @test
     */
    public function body($resource)
    {
        $this->assertSame('Hello, BEAR', $resource->body);
    }
}
