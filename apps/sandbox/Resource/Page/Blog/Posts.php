<?php
namespace sandbox\Resource\Page\Blog;

use BEAR\Resource\Client as Resource;
use BEAR\Resource\Annotation\Provides;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Link\View as View;
use BEAR\Framework\Inject\WebContextInject;
use BEAR\Framework\Args;
use BEAR\Framework\Annotation\Cache;
use BEAR\Framework\Annotation\CacheUpdate;
use BEAR\Framework\Annotation\Html;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * @Html
 */
class Posts extends Page
{
    use WebContextInject;

    public $body = [
        'posts' => [] //
    ];

    private $resource;

    /**
     * @Inject
     */
    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Get
     *
     * @Cache
     */
    public function onGet()
    {
        $this['posts'] = $this->resource->get->uri('app://self/posts')->request();
        return $this;
    }

    /**
     * Post
     *
     * @param string $title
     * @param string $body
     *
     * @CacheUpdate
     */
    public function onPost($title, $body)
    {
        // create post
        $this->resource
        ->post
        ->uri('app://self/posts')
        ->withQuery(['title' => $title, 'body' => $body])
        ->eager->request();

        // redirect
        $this->code = 301;
        $this->headers = ['Location' => '/blog/posts'];
        return $this;
    }

    /**
     * @Provides
     */
    public function provideArgs(Args &$args)
    {
    }
}
