<?php
namespace sandbox\tests\Resource\App\Blog;

use sandbox\App;
use BEAR\Resource\Annotation\Post;

class AppPostsTest extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        $pdo = require App::DIR . '/tests/scripts/db.php';
        return $this->createDefaultDBConnection($pdo, 'mysql');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(App::DIR .'/seed.xml');
    }

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
        $app = App::factory(App::RUN_MODE_TEST, true);
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
        $resource = $this->resource->get->uri('app://self/blog/posts')->eager->request();
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
     * Type ?
     *
     * @depends resource
     * @test
     */
    public function type($resource)
    {
        $this->assertInternalType('array', $resource->body);
    }

    /**
     * Renderable ?
     *
     * @depends resource
     * @test
     */
    public function render($resource)
    {
        $html = (string) $resource;
        $this->assertInternalType('string', $html);
    }

    /**
     * @test
     */
    public function post()
    {
        // inc 1
        $before = $this->getConnection()->getRowCount('posts');
        $response = $this->resource
        ->post
        ->uri('app://self/blog/posts')
        ->withQuery(['title' => 'test_title', 'body' => 'test_body'])
        ->eager
        ->request();
        $this->assertEquals($before + 1, $this->getConnection()->getRowCount('posts'), "faild to add post");

        // new post
        $body = $this->resource
        ->get
        ->uri('app://self/blog/posts')
        ->withQuery(['id' => 4])
        ->eager
        ->request()->body;

        return $body;
    }

    /**
     * @test
     * @depends post
     */
    public function postData($body)
    {
        $this->assertEquals('test_title', $body['title']);
        $this->assertEquals('test_body', $body['body']);
    }

    /**
     * @test
     */
    public function delete()
    {
        // dec 1
        $before = $this->getConnection()->getRowCount('posts');
        $response = $this->resource
        ->delete
        ->uri('app://self/blog/posts')
        ->withQuery(['id' => 1])
        ->eager
        ->request();
        $this->assertEquals($before - 1, $this->getConnection()->getRowCount('posts'), "faild to delete post");
    }
}
