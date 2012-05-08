<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework;

use Aura\Autoload\Loader;
use Doctrine\Common\Annotations\AnnotationRegistry;

require_once __DIR__ . '/AbstractAppContext.php';

/**
 * Framework
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class Framework
{
    /**
     * BEAR.Sunday
     *
     * Framework version identification
     */
    const VERSION = '0.1.1alpha';

    /**
     * Set standard expection handler
     *
     * @return void
     */
    public function setExceptionHandler()
    {
        include dirname(dirname(dirname(__DIR__))) . '/scripts/exception_handler/standard.php';
        return $this;
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

        $system = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));
        include_once $system . '/vendor/Aura/Autoload/src.php';
        $loader = new Loader;
        $namespacesBase = include  $system . '/vendor' . DIRECTORY_SEPARATOR . '.composer/autoload_namespaces.php';
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
