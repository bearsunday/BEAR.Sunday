<?php
namespace demoworld\Resource\Page\Http;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Resource\Resource,
    BEAR\Framework\Link\View\Haanga as HaangaView;

/**
 * HTTP resource page
 *
 */
class GoogleNews extends Page
{
    use HaangaView;

    /**
     * @var ResourceObject
     */
    protected $greeting;

    /**
     * Resource
     *
     * @var Client
     */
    protected $resource;

    /**
     * @param Resource $resource Resource Client
     *
     * @Inject
     */
    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return ResourceObject
     */
    public function onGet()
    {
        $uri = 'http://news.google.com/news?hl=ja&ned=us&ie=UTF-8&oe=UTF-8&output=rss';
        $response = $this->resource->get->uri($uri)->eager->request();
        $item = $response->body->channel->item;
        $this['news'] = ['title' => $item->title, 'pubDate' => $item->pubDate, 'link' =>  $item->link];
        return $this;
    }
}
