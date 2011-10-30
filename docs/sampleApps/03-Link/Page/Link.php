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
    public function onGet($nickname)
    {
       $this->resource->get($this->user, ['nickname' => $nickname])->set('user');
    }
    
    public function onLinkProfile(Ro $result)
    {
        return '/user/' . $result['user']['nickname'] . '/profile'
    }

    
    public function onLinkTwitter(Ro $result)
    {
        return 'http://twitter.com/#!/' . $result['user']['twitter_id'] '/';
    }
    
    public function onLinkHtml(Ro $result)
    {
        return 'view://self/user/special';
    }
}
