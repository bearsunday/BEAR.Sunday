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
    public function __construct(AppContext $app)
    {
        $this->app = $app;
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
        $key = (string)$this->app;
        $fetched = apc_fetch($key, $hasCache);
        if ($hasCache) {
            list($resource, $page) = unserialize($fetched);
        } else {
            $resourceFactory = $this->app->getResourceFactory();
            try {
                list($resource, $page) =  $resourceFactory($this->app->name, $pageUri);
            } catch (NotReadable $e) {
                throw new Exception\ResourceNotFound($pageUri, 404, $e);
            } catch (\Exception $e) {
                throw $e;
            }
            // application fixed instance ($di, $resource)
            $appModule =  '\\' . $this->app->name. '\\Module\\AppModule';
            apc_store($key, serialize([$resource, $page]));
            // serializable test
            unserialize(serialize($page));
        }
        $providesHandler = require $this->systemPath . '/vendor/BEAR.Resource/scripts/provides_handler.php';
        /* @var $resource \BEAR\Resoure\Client */
        $resource->attachParamProvider('Provides', $providesHandler);
        return [$resource, $page];
    }
}
