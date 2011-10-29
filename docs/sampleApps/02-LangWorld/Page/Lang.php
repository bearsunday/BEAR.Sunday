<?php
namespace BEAR\Framework\HelloWorld;
use BEAR\Resource\ResourceObject\Resource;
use BEAR\Resource\ResourceObject\Page;
use BEAR\Resource\Cleint;

class LangWorld extends Page
{
    /**
     * Constructor
     *
     * @Inject
	 * @Named("varName")
     */
    public function __construct(
		Resource $resource,
		Ro $greeting
	) {
        $this->resource = $resource;
        $this->greeting = $greeting;
    }

    /**
     * @Web
     */
    public function onWeb()
    {
        $this->injectGet('lang', 'ja');
    }
    
    /**
     * @Get
     */
    public function onGet($lang)
    {
       $this->resource->get($this->greeting, ['lang' => $lang])->set('greetings');
    }
}
