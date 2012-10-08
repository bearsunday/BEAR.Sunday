<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Framework;

use Aura\Autoload\Loader;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Framework
 *
 * @package    BEAR.Framework
 * @subpackage Framework
 */
final class Framework
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
    const VERSION = '0.4.3';

    /**
     * Constructor
     */
    public function __construct()
    {
        // global setting
        self::$systemRoot = dirname(dirname(dirname(dirname(__DIR__))));
        umask(0);
    }

    /**
     *  Set auto loader
     *
     * @param string $namespace
     * @param string $appDir
     * @param array  $namespaces
     *
     * @return \BEAR\Sunday\Framework
     */
    public function setLoader($namespace, $appDir, array $namespaces = [])
    {
    }
}
