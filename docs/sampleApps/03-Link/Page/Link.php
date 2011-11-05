<?php
namespace BEAR\Framework\HelloWorld;

use BEAR\Resource\Resource,
    BEAR\Resource\ResourceObject\AbstractsPage,
    BEAR\Resource\Object as Ro;

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

    public function onWeb()
    {
        $this->injectGet('lang', 'ja');
    }
    
    public function onGet($nickname)
    {
       $this['user'] = $this->resource->objcet($this->user)->get(['nickname' => $nickname]);
    }
    
    /**
     * @param Ro $result
     */
    public function onLinkProfile(Ro $result)
    {
        return 'page://self/user/' . $result['user']['nickname'] . '/profile'
    }

    
    /**
     * @param Ro $result
     */
    public function onLinkTwitter(Ro $result)
    {
        return 'http://twitter.com/#!/' . $result['user']['twitter_id'] '/';
    }
}
