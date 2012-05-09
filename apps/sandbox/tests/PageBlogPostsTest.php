<?php
namespace sandbox;

class PageBlogPostsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Resource client
	 *
	 * @var BEAR\Resource\Resourcce
	 */
	private $resource;

	protected function setUp()
	{
		static $app;

		parent::setUp();
		$app = App::factory(App::RUN_MODE_STAB, false);
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
		$page = $this->resource->get->uri('page://self/blog/posts')->eager->request();
		$this->assertSame(200, $page->code);
		return $page;
	}

	/**
	 * Has page app resource ?
	 *
	 * @depends resource
	 */
	public function test_Graph($page)
	{
		$this->assertArrayHasKey('posts', $page->body);
	}

	/**
	 * Is app resource request?
	 *
	 * @depends resource
	 */
	public function test_AppResourceType($page)
	{
		$this->assertInstanceOf('BEAR\Resource\Request', $page->body['posts']);
	}

	/**
	 * Is valid app resource uri ?
	 *
	 * @depends resource
	 */
	public function test_AppResourceUri($page)
	{
		$posts = $page->body['posts'];
		$this->assertSame('get app://self/posts', $posts->toUri());
	}

	/**
	 * Rendable ?
	 *
	 * @depends resource
	 */
	public function test_Render($page)
	{
		$html = (string)$page;
		$this->assertInternalType('string', $html);
	}

	/**
	 * Html Rendered ?
	 *
	 * @depends resource
	 */
	public function test_RenderHtml($page)
	{
		$html = (string)$page->body;
		$this->assertContains('</html>', $html);
	}
}