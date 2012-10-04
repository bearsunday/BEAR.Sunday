<?php
namespace tests\Mock\ResourceObject;

use BEAR\Sunday\Annotation\Cache;
use BEAR\Sunday\Annotation\CacheUpdate;
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
