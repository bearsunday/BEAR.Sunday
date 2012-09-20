<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Provider;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ApcCache;
use Ray\Di\ProviderInterface as Provide;

/**
 * APC cached reader
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class CachedReaderProvider implements Provide
{
    /**
     * Return instance
     *
     * @return CacheAdapter
     */
    public function get()
    {
        $reader = new CachedReader(
            new AnnotationReader,
            new ApcCache,
            $debug = false
        );

        return $reader;
    }
}
