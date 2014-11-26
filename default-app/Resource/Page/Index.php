<?php
namespace BEAR\Sunday\Resource\Page;

use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    /**
     * @Embed(rel="greeting", src="app://self/greeting{?name}")
     */
    public function onGet($name = 'World')
    {
        return $this;
    }
}
