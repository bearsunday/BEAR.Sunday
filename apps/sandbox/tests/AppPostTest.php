<?php
namespace sandbox;

class AppPostTest extends \PHPUnit_Framework_TestCase
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
        $resource = $this->resource->get->uri('app://self/posts')->eager->request();
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
     * Rendable ?
     * 
     * @depends resource
     * @test
     */
    public function type($resource)
    {
    	$this->assertInternalType('array', $resource->body);
    }
    
    /**
     * Rendable ?
     * 
     * @depends resource
     * @test
     */
    public function render($resource)
    {
		$html = (string)$resource;
		$this->assertInternalType('string', $html);
    }
    
}