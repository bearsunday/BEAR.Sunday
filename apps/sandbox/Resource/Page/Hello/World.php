<?php
namespace sandbox\Resource\Page\Hello;

use BEAR\Framework\Resource\AbstractPage as Page;

/**
 * Hello World
 *
 */
class World extends Page
{
    public function __construct()
    {
    }

    /**
     * Get
     */
    public function onGet()
    {
        $this['greeting'] ='Hello, World !';

        return $this;
    }
}
