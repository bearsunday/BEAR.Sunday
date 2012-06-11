<?php
namespace sandbox\Resource\Page\Blog\Posts;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;
use BEAR\Framework\Annotation\Cache;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Blog entry pager page
 *
 * @package    sandbox
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
     *
     */
    public function onGet()
    {
        $this['posts'] = $this->resource->get->uri('app://self/blog/posts/pager')->eager->request();
        return $this;
    }
}
