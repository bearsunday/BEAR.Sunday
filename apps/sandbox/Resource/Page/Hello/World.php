<?php
namespace sandbox\Resource\Page\Hello;

use BEAR\Framework\Resource\AbstractPage as Page;

/**
 * Hello World
 *
 */
class World extends Page
{
    /**
     * Get
     */
    public function onGet()
    {
        $this['greeting'] ='Hello, World !';

        return $this;
    }
}
