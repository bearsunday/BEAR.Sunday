<?php
namespace BEAR\Framework\HelloWorld;

use BEAR\Resource\ResourceObject\Resource,
    BEAR\Resource\ResourceObject\Page,
    BEAR\Resource\Cleint;

/**
 * QueryWorld by query
 */
class QueryWorld extends Page
{
    private $resouce;
    private $greeting;
    private $webContext;

    /**
     * @Inject
     * @Named("greeitng=greeting")
     */
    public function __construct(
        Resource $resource,
        Ro $greeting,
        Webcontext $webContext
    ){
        $this->resource = $resource;
        $this->greeting = $greeting;
        $this->webContext $webContext
    }

    /**
     * @param string $lang
     */
    public function onGet($lang)
    {
       $this['greeting'] = $this->resource->get->object($this->greeting)->withQuery(['lang' => $lang])->request();
    }

    /**
     * @Provides("lang")
     */
    public function onProvideLang()
    {
        $lang = $this->webContext->getQuery('lang', 'ja');
        return $lang;
    }
}
