<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework;

use Aura\Autoload\Loader;
use Doctrine\Common\Annotations\AnnotationRegistry;

require_once __DIR__ . '/AppContext.php';
require_once __DIR__ . '/Inject/AppDependencyInject.php';

/**
 * Framework
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class Framework
{
    /**
     * BEAR.Sunday root path
     *
     * @var system
     */
    public static $systemRoot;

    /**
     * BEAR.Sunday
     *
     * Framework version identification
     */
    const VERSION = '0.2.0alpha';

    /**
     * Constructor
     */
    public function __construct()
    {
        // global setting
        self::$systemRoot = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));
        umask(0);
    }

    /**
     * Set auto loader
     *
     * @return void
     */
    public function setLoader($namespace, $appDir, array $namespaces = [])
    {
        static $loader;

        if (! is_null($loader)) {
            // unregister for another app
            spl_autoload_unregister([$loader, 'load']);
        }

        $system = self::$systemRoot;
        include_once $system . '/vendor/Aura/Autoload/src.php';
        $loader = new Loader;
//      $loader->setMode(Loader::MODE_DEBUG);
        $namespacesBase = include $system . '/vendor/composer/autoload_namespaces.php';
        $namespacesBase += [
            $namespace  => dirname($appDir),
            'BEAR\Framework' => $system . '/package/BEAR/Framework/src/'
        ];
        $namespacesBase += $namespaces;
        $loader->setPaths($namespacesBase);
        $loader->register();
        AnnotationRegistry::registerAutoloadNamespace('Ray\Di\Di\\', $system . '/vendor/Ray/Di/src/');
        AnnotationRegistry::registerAutoloadNamespace('BEAR\Resource\Annotation\\', $system . '/vendor/BEAR/Resource/src/');
        AnnotationRegistry::registerAutoloadNamespace('BEAR\Framework\Annotation\\', $system . '/package/BEAR/Framework/src/');
        AnnotationRegistry::registerAutoloadNamespace($namespace . '\Annotation', dirname($appDir));

        return $this;
    }
}
