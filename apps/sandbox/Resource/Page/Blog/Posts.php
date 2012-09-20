<?php
/**
 * App resource
 *
 * @package    sandbox
 * @subpackage resource
 */
namespace sandbox\Resource\Page\Blog;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;
use BEAR\Framework\Annotation\Cache;
use BEAR\Framework\Annotation;
use Ray\Di\Di\Inject;

/**
 * Blog index page
 *
 * @package    sandbox
 * @subpackage page
 */
class Posts extends Page
{
    use ResourceInject;

    /**
     * Contents
     *
     * @var array
     */
    public $body = [
        'posts' => ''
    ];

    /**
     * Get
     *
     * @Cache
     * @internal Cache "request", not the result of request. never changed.
     */
    public function onGet()
    {
        $this['posts'] = $this->resource->get->uri('app://self/blog/posts')->request();

        return $this;
    }

    /**
     * Delte
     *
     * @param int $id
     *
     * @return self
     */
    public function onDelete($id)
    {
        // delete
        $this->resource
        ->delete
        ->uri('app://self/blog/posts')
        ->withQuery(['id' => $id])
        ->eager
        ->request();

        // redirect
        $this->headers['location'] = '/blog/posts';
        return $this;
    }
}
