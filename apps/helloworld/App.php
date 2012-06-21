<?php
/**
 * sandbox
 *
 * @package App.sandbox
 */
namespace helloworld;

use BEAR\Framework\Framework;
use BEAR\Framework\Module\FrameworkModule;
use BEAR\Framework\AppContext;
use BEAR\Framework\Inject\AppDependencyInject;
use Ray\Di\Injector;
use LogicException;

require_once dirname(dirname(__DIR__)) . '/vendor/smarty/smarty/libs/Smarty.class.php';

/**
 * Applicaton
 *
 * @package helloworld
 */
final class App implements AppContext
{
    use AppDependencyInject;
    
    /** Version @var string */
    const VERSION = '0.1.0';

    /**
     * Return application instance
     *
     * @param integer $runMode
     */
    public static function factory($runMode, $useCache = false)
    {
        // configure framework
        (new Framework)->setLoader(__NAMESPACE__, __DIR__);

        // configure application
        $cacheKey = 'app' . __NAMESPACE__ . PHP_SAPI . $runMode;
        if ($useCache && apc_exists($cacheKey)) {
            $app = apc_fetch($cacheKey);
            return $app;
        }
        // run mode
        $modules = [new FrameworkModule(__NAMESPACE__, __DIR__ . '/tmp', __DIR__ . '/log'), new Module\AppModule];
        $injector = Injector::create($modules, $useCache);
        $app = $injector->getInstance(__CLASS__);
        $useCache ? apc_store($cacheKey, $app) : apc_clear_cache('user');
        return $app;
    }
}