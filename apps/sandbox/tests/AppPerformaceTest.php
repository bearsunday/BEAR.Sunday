<?php
namespace sandbox;

class AppPerformanceTest extends \PHPUnit_Framework_TestCase
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
		$app = App::factory(App::RUN_MODE_PROD, false);
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
        $resource = $this->resource->get->uri('app://self/performance')->eager->request();
        $this->assertSame(200, $resource->code);
        return $resource;
    }
    
    /**
     * What does page have ?
     * 
     * @depends resource
     */
    public function graph($resource)
    {
    }
    
    /**
     * Renderable ?
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
     */
    public function render($resource)
    {
    }
    
}