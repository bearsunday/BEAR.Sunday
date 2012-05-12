<?php
namespace sandbox\Resource\Page\Blog\Posts;

use BEAR\Resource\Client as Resource;
use BEAR\Resource\Annotation\Provides;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 */
class Post extends Page
{
	use ResourceInject;
	
    public $body = [
        'post' => ['title' => 'aaa', 'body' => 'bbb'],
    ];

    /**
     * Get
     */
    public function onGet($id)
    {
        $this['post'] = $this->resource->get->uri('app://self/posts')->withQuery(['id' => $id])->eager->request()->body;
        return $this;
    }
}
