<?php
namespace sandbox\Resource\Page;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject as Page;
use BEAR\Framework\Link\View\Twig as View;

if (class_exists('\sandbox\Resource\Page\Hello', false))
{
    return;
}
/**
 * Greeting page
 */
class Hello extends Page
{
    use View;

    /**
     * @return self
     */
    public function onGet()
    {
        $this['greeting'] = 'BEAR';
        return $this;
    }
}
