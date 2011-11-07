<?php
namespace BEAR\Framework\HelloWorld;
use Aura\Web\Context as WebContext;

/**
 * Lang by cookie
 */
class CookieWorld extends Page
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
     * @Linked
     */
    public function onGet($lang)
    {
       $this['greeting'] = $this->resource->get->object($this->greeting)->withQuery(['lang' => $lang])->request();
    }
}
