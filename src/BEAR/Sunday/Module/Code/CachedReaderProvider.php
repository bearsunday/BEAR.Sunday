<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Code;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ApcCache;
use Ray\Di\ProviderInterface as Provide;

/**
 * APC cached reader provider
 */
class CachedReaderProvider implements Provide
{
    /**
     * @return CachedReader
     */
    public function get()
    {
        $reader = new CachedReader(new AnnotationReader, new ApcCache, true);

        return $reader;
    }
}
