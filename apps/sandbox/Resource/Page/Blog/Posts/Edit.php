<?php
/**
 * App resource
 *
 * @package    Sandbox
 * @subpackage resource
 */
namespace Sandbox\Resource\Page\Blog\Posts;

use BEAR\Resource\Resource;
use BEAR\Sunday\Resource\AbstractPage as Page;
use BEAR\Sunday\Inject\ResourceInject;
use Ray\Di\Di\Inject;
use Sandbox\Annotation\Form;

/**
 * Edit post page
 *
 * @package    Sandbox
 * @subpackage page
 */
class Edit extends Page
{
    use ResourceInject;

    /**
     * Contents
     *
     * @var array
     */
    public $body = [
        'errors' => ['title' => '', 'body' => ''],
        'submit' => ['title' => '', 'body' => '']
    ];

    /**
     * Get
     *
     * @param int $id
     */
    public function onGet($id)
    {
        $this['submit'] = $this->resource->get->uri('app://self/blog/posts')->withQuery(['id' => $id])->eager->request()->body;
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
        ->uri('app://self/blog/posts')
        ->withQuery(['id' => $id, 'title' => $title, 'body' => $body])
        ->eager->request();

        // redirect
        $this->code = 303;
        $this->headers = ['Location' => '/blog/posts'];

        return $this;
    }
}
