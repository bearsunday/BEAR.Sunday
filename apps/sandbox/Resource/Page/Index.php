<?php
/**
 * App resource
 *
 * @package    sandbox
 * @subpackage resource
 */
namespace sandbox\Resource\Page;

use BEAR\Framework\Resource\AbstractPage as Page;
use BEAR\Resource\Link;
use BEAR\Framework\Inject\ResourceInject;
use BEAR\Framework\Framework\Framework;
use Ray\Di\Di\Inject;

/**
 * Index page
 */
class Index extends Page
{
    use ResourceInject;

    /**
     * Links
     *
     * @var array
     */
    public $links = [
        'helloworld' => [Link::HREF => 'page://self/hello/world'],
        'blog' => [Link::HREF => 'page://self/blog/posts'],
        'restbucks' => [Link::HREF => 'page://self/restbucks/index']
    ];

    public function __construct()
    {
        $this['greeting'] ='Hello, BEAR.Sunday.';
        $this['version'] = [
            'php'  => phpversion(),
            'BEAR' => Framework::VERSION
        ];
        $this['extentions'] = [
            'apc'  => extension_loaded('apc') ? phpversion('apc') : 'n/a',
            'memcache'  => extension_loaded('memcache') ? phpversion('memcache') : 'n/a',
            'mysqlnd'  => extension_loaded('mysqlnd') ? phpversion('mysqlnd') : 'n/a',
            'pdo_sqlite'  => extension_loaded('pdo_sqlite') ? phpversion('pdo_sqlite') : 'n/a',
            'Xdebug'  => extension_loaded('Xdebug') ? phpversion('Xdebug') : 'n/a',
            'xhprof' => extension_loaded('xhprof') ? phpversion('xhprof') : 'n/a'
        ];
    }

    /**
     * Get
     */
    public function onGet()
    {
        $cache = (PHP_SAPI !== 'cli') ? apc_cache_info('user') : ['num_entries' => 0, 'mem_size' => 0];
        $this['apc'] = [
           'total' => $cache['num_entries'],
           'size' => $cache['mem_size']
        ];
        // page speed.
        $this['performance'] = $this->resource->get->uri('app://self/performance')->request();

        return $this;
    }
}
