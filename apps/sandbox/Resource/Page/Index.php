<?php
namespace sandbox\Resource\Page;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Framework\Inject\ResourceInject;
use BEAR\Framework\Framework;
use APCIterator;
use Ray\Di\Di\Inject;

/**
 * Index page
 */
class Index extends Page
{
    use ResourceInject;

    public function __construct()
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
    }

    /**
     * Get
     */
    public function onGet()
    {
        $apc = new APCIterator('user');
        $this['apc'] = [
           'total' => $apc->getTotalCount(),
           'size' => number_format($apc->getTotalSize())
        ];
    	// page / sec
        $this['performance'] = $this->resource->get->uri('app://self/performance')->request();
        return $this;
    }
}