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
    /**
     * @Inject
     * @Named("greeitng=greeting")
     */
    public function __construct(
        Resource $resource,
        Ro $greeting
    ){
        $this->resource = $resource;
        $this->greeting = $greeting;
    }
    
    /**
     * @Web
     */
    public function onGet($lang)
    {
       $this['greeting'] = $this->resource->get->object($this->greeting)->withQuery(['lang' => $lang])->request();
    }

    public function onWeb(Webcontext $webContext)
    {
        $args = $webContext->getQuery('lang', 'ja');
        return $args;
    }    
}
