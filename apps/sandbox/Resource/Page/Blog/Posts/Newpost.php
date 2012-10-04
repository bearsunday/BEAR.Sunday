<?php
/**
 * App resource
 *
 * @package    Sandbox
 * @subpackage resource
 */
namespace Sandbox\Resource\Page\Blog\Posts;

use BEAR\Resource\Resource;
use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;
use Ray\Di\Di\Inject;
use Sandbox\Annotation\Form;
use BEAR\Resource\Link;

/**
 * New post page
 *
 * @package    Sandbox
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
        'submit' => ['title' => '', 'body' => ''],
        'code' => 200
    ];

    public $links = [
        'back' => [Link::HREF => 'page://self/blog/posts']
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
        $response = $this->resource
        ->post
        ->uri('app://self/blog/posts')
        ->withQuery(['title' => $title, 'body' => $body])
        ->eager->request();

        $this['code'] = $response->code;
        $this->links += $response->links;

        // redirect
//      $this->code = 303;
//      $this->headers = ['Location' => '/blog/posts'];
        return $this;
    }
}
