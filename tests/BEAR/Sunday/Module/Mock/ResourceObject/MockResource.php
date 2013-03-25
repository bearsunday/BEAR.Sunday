<?php
namespace BEAR\Sunday\Module\Mock\ResourceObject;

use BEAR\Resource\AbstractObject as ResourceObject;

class MockResource extends ResourceObject
{
    /**
     * Get
     *
     * @Cache
     *
     * @return array
     */
    public function onGet()
    {
        return microtime(true);
    }

    /**
     * Post
     *
     * @CacheUpdate
     */
    public function onPost()
    {
        return $this;
    }

}
