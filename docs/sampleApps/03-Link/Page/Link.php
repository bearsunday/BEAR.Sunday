<?php
namespace BEAR\Framework\HelloWorld;

use BEAR\Resource\Resource,
    BEAR\Resource\ResourceObject\AbstractsPage,
    BEAR\Resource\Object as Ro;

class LinkWorld extends QueryWorld
{
    /**
     * @param Ro $result
     */
    public function onLinkProfile()
    {
        return '/user/' . $this['user']['nickname'] . '/profile'
    }

    
    /**
     * @param Ro $result
     */
    public function onLinkTwitter(Ro $result)
    {
        return 'http://twitter.com/#!/' . $this['user']['twitter_id'] '/';
    }
}
