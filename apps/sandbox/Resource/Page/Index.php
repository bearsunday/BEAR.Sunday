<?php
namespace sandbox\Resource\Page;

use BEAR\Resource\Client as Resource;
use BEAR\Resource\Annotation\Provides;
use BEAR\Resource\Renderable;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Link\View as View;
use BEAR\Framework\Inject\WebContextInject;
use BEAR\Framework\Args;
use BEAR\Framework\Annotation\Cache;
use BEAR\Framework\Annotation\CacheUpdate;
use BEAR\Framework\Annotation\Html;
use BEAR\Framework\Framework;

/**
 * @Html
 */
class Index extends Page
{
    /**
     * Get
     */
    public function onGet()
    {
        $this['greeting'] ='Hello, BEAR.Sunday.';
        $this['version'] = [
            'php'  => phpversion(),
            'BEAR' => Framework::VERSION
        ];
        return $this;
    }

//     /**
//      * Set renderer
//      *
//      * @param Stringer $stringer
//      *
//      * @Inject
//      * @Named("php_template")
//      */
// //     public function setRederer(Renderable $renderer)
// //     {
// //         $this->renderer = $renderer;
// //     }
}