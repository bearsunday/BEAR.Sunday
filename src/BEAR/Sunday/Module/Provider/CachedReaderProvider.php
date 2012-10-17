<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Provider;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ApcCache;
use Ray\Di\ProviderInterface as Provide;

/**
 * APC cached reader
 *
 * @package    BEAR.Sunday
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
            false
        );

        return $reader;
    }
}
