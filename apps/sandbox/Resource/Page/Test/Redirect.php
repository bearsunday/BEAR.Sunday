<?php
namespace sandbox\Resource\Page\Test;

use BEAR\Framework\Resource\AbstractPage as Page;

/**
 * Redirect page
 */
class Redirect extends Page
{
    public function __construct()
    {
    }

    /**
     * Get
     */
    public function onGet()
    {
        $this->code = 302;
        $this->headers = ['Location' => '/'];
        return $this;
    }
}
