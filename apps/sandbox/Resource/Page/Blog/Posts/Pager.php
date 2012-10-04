<?php
/**
 * App resource
 *
 * @package    Sandbox
 * @subpackage resource
 */
namespace Sandbox\Resource\Page\Blog\Posts;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;
use Ray\Di\Di\Inject;

/**
 * Blog entry pager page
 *
 * @package    Sandbox
 * @subpackage page
 */
class Pager extends Page
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
     */
    public function onGet()
    {
        $this['posts'] = $this->resource->get->uri('app://self/blog/posts/pager')->eager->request();

        return $this;
    }
}
