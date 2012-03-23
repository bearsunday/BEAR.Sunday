<?php
namespace sandbox\Resource\Page;

use BEAR\Resource\AbstractObject as Page;
use BEAR\Resource\Client as Resource;
use BEAR\Resource\Annotation\Provides;
use BEAR\Framework\Link\View\Smarty3 as View;
use BEAR\Framework\Annotation\Cache;
use BEAR\Framework\Inject\WebContextInject;
use BEAR\Framework\Args;

class Posts extends Page
{
    use View;

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
     * @Cache(3)
     */
    public function onGet()
    {
        $this['posts'] = $this->resource->get->uri('app://self/posts')->linkSelf('view')->request();
        return $this;
    }

    /**
     * Post
     *
     * @param string $title
     * @param string $body
     *
     * @return self
     */
    public function onPost($title, $body)
    {
        $this->resource
        ->post
        ->uri('app://self/posts')
        ->withQuery(['title' => $title, 'body' => $body])
        ->eager->request();

        $code = 301;
        $this->headers = ['Location' => '/posts'];
        return $this;
    }

    /**
     * @Provides
     */
    public function provideArgs(Args &$args)
    {
        $args['title'] = $this->webContext->getPost('title', 'untitled');
        $args['body'] = $this->webContext->getPost('body');
        $args['body'] = 'OKOK';
    }
}