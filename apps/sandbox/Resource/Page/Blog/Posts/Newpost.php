<?php
namespace sandbox\Resource\Page\Blog\Posts;

use BEAR\Resource\Resource;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;

use Ray\Di\Di\Inject;
use sandbox\Annotation\Form;

/**
 * New post page
 *
 * @package    sandbox
 * @subpackage page
 */
class Newpost extends Page
{
    use ResourceInject;

    /**
     * Contentes
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
    public function onGet()
    {
        return $this;
    }

    /**
     * Post
     *
     * @param string $title
     * @param string $body
     *
     * @Form
     */
    public function onPost($title, $body)
    {
        // create post
        $this->resource
        ->post
        ->uri('app://self/blog/posts')
        ->withQuery(['title' => $title, 'body' => $body])
        ->eager->request();

        // redirect
        $this->code = 303;
        $this->headers = ['Location' => '/blog/posts'];

        return $this;
    }
}
