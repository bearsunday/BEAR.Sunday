<?php
namespace BEAR\Framework\HelloWorld;

use BEAR\Resource\Resource,
    BEAR\Resource\ResourceObject\AbstractsPage,
    BEAR\Resource\Object as Ro;

class LinkWorld extends QueryWorld
{
    /**
     * Constructor
     *
     * @Inject
     */
    public function __construct(
        Resource $resource,
        Ro $greeting
    ){
        $this->resource = $resource;
        $this->greeting = $greeting;
    }

    public function onLinkProfile()
    {
        return 'page://self/user/' . $result['user']['nickname'] . '/profile'
    }

    
    /**
     * @param Ro $result
     */
    public function onLinkTwitter(Ro $result)
    {
        return 'http://twitter.com/#!/' . $this['user']['twitter_id'] '/';
    }
}
