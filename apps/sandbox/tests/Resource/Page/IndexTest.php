<?php
namespace sandbox;

class PageIndexTest extends \PHPUnit_Framework_TestCase
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
        $app = App::factory(App::RUN_MODE_PROD, true);
        $this->resource = $app->resource;
    }

    /**
     * page://self/blog/posts
     *
     * @test
     */
    public function resource()
    {
        // resource request
        $page = $this->resource->get->uri('page://self/index')->eager->request();
        $this->assertSame(200, $page->code);

        return $page;
    }

    /**
     * What does page have ?
     *
     * @depends resource
     */
    public function test_graph($page)
    {
        $this->assertArrayHasKey('greeting', $page->body);
        $this->assertArrayHasKey('version', $page->body);
        $this->assertArrayHasKey('extentions', $page->body);
        $this->assertArrayHasKey('apc', $page->body);
        $this->assertArrayHasKey('performance', $page->body);
    }

    /**
     * Is app resource request?
     *
     * @depends resource
     */
    public function test_AppResourceType($page)
    {
        $this->assertInstanceOf('BEAR\Resource\Request', $page->body['performance']);
    }

    /**
     * Is valid app resource uri ?
     *
     * @depends resource
     */
    public function test_AppResourceUri($page)
    {
        $this->assertSame('app://self/performance', $page->body['performance']->toUri());
    }

    /**
     * Renderable ?
     *
     * @depends resource
     */
    public function test_Render($page)
    {
        $html = (string) $page;
        $this->assertInternalType('string', $html);
    }

    /**
     * Html Rendered ?
     *
     * @depends resource
     */
    public function test_RenderHtml($page)
    {
        $html = (string) $page->body;
        $this->assertContains('</html>', $html);
    }
}
