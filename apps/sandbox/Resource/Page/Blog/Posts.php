<?php
namespace sandbox\Resource\Page\Blog;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;
use BEAR\Framework\Annotation\Cache;

class Posts extends Page
{
	use ResourceInject;
	
    public $body = [
        'posts' => ''
    ];

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
     * Delte
     * 
     * @param int $id
     */
    public function onDelete($id)
    {
        // delete
        $this->resource
        ->delete
        ->uri('app://self/posts')
        ->withQuery(['id' => $id])
        ->eager->request();
        
        // message
        $this['message'] = 'Entry deleted.';
        return $this->onGet();
    }
}
