<?php
namespace sandbox\Resource\Page\Blog;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

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

        // message
        $this['message'] = 'Entry deleted.';
        return $this->onGet();
    }
}
