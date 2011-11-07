<?php
namespace BEAR\Framework\HelloWorld;

use BEAR\Resource\ResourceObject\Resource,
    BEAR\Resource\ResourceObject\Page,
    BEAR\Resource\Cleint;

/**
 * ProvideWorld by @Provide
 */
class ProvidesWorld extends Page
{
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
    }
    
    public function onGet($lang)
    {
       $this['greeting'] = $this->resource->get->object($this->greeting)->withQuery(['lang' => $lang])->request();
    }

    /**
     * @Provides
     * 
     * @var $lang
     */
    public function provideLang()
    {
        $lang = $this->webContext->getQuery('lang', 'ja');
        return $lang;
    }    
}
