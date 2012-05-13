<?php
namespace sandbox\Resource\Page\Blog\Posts;

use BEAR\Resource\Client as Resource;
use BEAR\Resource\Annotation\Provides;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Link\View as View;
use BEAR\Framework\Inject\WebContextInject;
use BEAR\Framework\Inject\ResourceInject;
use BEAR\Framework\Args;
use BEAR\Framework\Annotation\Cache;
use BEAR\Framework\Annotation\CacheUpdate;
use BEAR\Framework\Annotation\Html;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use sandbox\Annotation\Form;

/**
 * @Html
 */
class Edit extends Page
{
    use ResourceInject;

    public $body = [
        'errors' => ['title' => '', 'body' => ''],
        'submit' => ['title' => '', 'body' => '']
    ];

    /**
     * Get
     *
     */
    public function onGet($id)
    {
        $this['submit'] = $this->resource->get->uri('app://self/posts')->withQuery(['id' => $id])->eager->request()->body;
        $this['id'] = $id;
        return $this;
    }

    /**
     * Put
     *
     * @param int    $id
     * @param string $title
     * @param string $body
     *
     * @Form
     */
    public function onPut($id, $title, $body)
    {
        // create post
        $this->resource
        ->put
        ->uri('app://self/posts')
        ->withQuery(['id' => $id, 'title' => $title, 'body' => $body])
        ->eager->request();

        // redirect
        $this->code = 303;
        $this->headers = ['Location' => '/blog/posts'];
        return $this;
    }
}
