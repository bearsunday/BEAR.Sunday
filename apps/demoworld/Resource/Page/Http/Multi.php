<?php
namespace demoworld\Resource\Page\Http;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Resource\Resource,
    BEAR\Framework\Link\View\Haanga as HaangaView;

/**
 * HTTP async mulitiple request page
 */
class Multi extends Page
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
     * @return self
     */
    public function onGet()
    {
        $uri1 = 'http://news.google.com/news?hl=ja&ned=us&ie=UTF-8&oe=UTF-8&output=atom&topic=h';
        $uri2 = 'http://news.google.com/news?hl=ja&ned=ja&ie=UTF-8&oe=UTF-8&output=atom&topic=po';
        $uri3 = 'http://news.google.com/news?hl=ja&ned=us&ie=UTF-8&oe=UTF-8&output=atom&topic=t';
        $uri4 = 'http://news.google.com/news?hl=ja&ned=us&ie=UTF-8&oe=UTF-8&output=atom&q=PHP';
        $response = $this->resource
        ->get->uri($uri1)->eager->sync->request()
        ->get->uri($uri2)->eager->sync->request()
        ->get->uri($uri3)->eager->sync->request()
        ->get->uri($uri4)->eager->eager->request();
        $news = [];
        foreach (range(0,3) as $i) {
            $news[$i] = [
            	'title' => $response->body[$i]->entry->title,
            	'updated' => $response->body[$i]->entry->updated
            ];
        }
        $this['news_top'] =$news[0];
        $this['news_topic'] =$news[1];
        $this['news_science'] =$news[2];
        $this['news_php'] =$news[3];
        return $this;
    }
}
