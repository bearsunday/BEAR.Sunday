<?php
/**
 * App resource
 *
 * @package    Sandbox
 * @subpackage resource
 */
namespace Sandbox\Resource\Page\Blog;

use BEAR\Sunday\Resource\AbstractPage as Page;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Sunday\Annotation\Cache;
use BEAR\Sunday\Annotation;
use Ray\Di\Di\Inject;

/**
 * Blog index page
 *
 * @package    Sandbox
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
