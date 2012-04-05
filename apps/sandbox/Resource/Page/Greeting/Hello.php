<?php
namespace sandbox\Resource\Page\Greeting;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Annotation\Html;

/**
 * Greeting
 *
 * @Html
 */
class Hello extends Page
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