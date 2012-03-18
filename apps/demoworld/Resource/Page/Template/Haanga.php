<?php
namespace demoworld\Resource\Page\template;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page,
    BEAR\Resource\Resource,
    BEAR\Framework\Link\View\Haanga as HaangaView;

class Haanga extends Page
{
    use HaangaView;

    public function __construct()
    {
    }

    /**
     * @return self
     */
    public function onGet()
    {
        $this['greeting'] = 'Hello Haanga';
        return $this;
    }
}
