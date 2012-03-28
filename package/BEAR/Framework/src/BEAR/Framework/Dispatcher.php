<?php
/**
 *  BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework;

use BEAR\Resource\Resource;
use Ray\Di\Definition,
    Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    Ray\Di\InjectorInterface as Inject;
use BEAR\Framework\Router,
    BEAR\Framework\DevRouter,
    BEAR\Framework\Exception\NotFound,
    BEAR\Framework\AbstractAppContext as AppContext;
use Aura\Autoload\Exception\NotReadable;

use Doctrine\Common\Cache\MemcacheCache as Cache;
use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;

/**
 * Dispatcher
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
final class Dispatcher
{
    /**
     * Application context
     *
     * @var AppContext
     */
    private $app;

    /**
     * System path
     *
     * @var string
     */
    private $systemPath;

    /**
     * Constructor
     *
     * @param string $appName
     * @param string $appPath
     */
    public function __construct(AppContext $app, Cache $cache = null)
    {
        $this->app = $app;
        $this->cache = $cache;
        $this->systemPath = dirname(dirname(dirname(dirname(dirname(__DIR__)))));
    }

    /**
     * Get instance
     *
     * @param string $pageUri Page resource path ("/hello/world")
     *
     * @return array [BEAR\Resource\Resource $resource, BEAR\Resource\Object $page]
     *
     * @throws Exception
     */
    public function getInstance($pageUri)
    {
        $mem = new \Memcache;
        $mem->addServer('localhost');
        $memcache = new Cache;
        $memcache->setMemcache($mem);
        $this->cache = new CacheAdapter($memcache);

        $key = $this->app->name . md5($pageUri);
        $cached = $this->cache->fetch($key);
        if ($cached) {
            list($resource, $page) = unserialize($cached);
        } else {
            $resource = $this->app->resource;
            try {
                $page = $resource->newInstance($pageUri);
            } catch (NotReadable $e) {
                try {
                    $page = $resource->newInstance($pageUri . 'index');
                } catch (NotReadable $e) {
                    throw new Exception\ResourceNotFound($pageUri, 404, $e);
                }
            } catch (\Exception $e) {
                throw $e;
            }
            $this->cache->save($key, serialize([$resource, $page]));
            // serializable test
            $page = unserialize(serialize($page));
        }
        return [$resource, $page];
    }
}
