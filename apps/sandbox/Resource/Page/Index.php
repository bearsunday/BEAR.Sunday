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
use BEAR\Framework\Inject\TmpDirInject;

/**
 * @Html
 */
class Index extends Page
{
    use TmpDirInject;

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
        $this['extentions'] = [
            'apc'  => extension_loaded('apc') ? 'Yes' : 'No',
            'memcache'  => extension_loaded('memcache') ? 'Yes' : 'No',
            'curl'  => extension_loaded('curl') ? 'Yes' : 'No',
            'mysqlnd'  => extension_loaded('mysqlnd') ? 'Yes' : 'No',
            'Xdebug'  => extension_loaded('Xdebug') ? 'Yes' : 'No',
            'xhprof' => extension_loaded('xhprof') ? 'Yes' : 'No'
        ];
        return $this;
    }
}