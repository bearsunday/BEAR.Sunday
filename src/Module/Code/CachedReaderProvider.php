<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Code;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\Cache;
use Ray\Di\ProviderInterface as Provide;
use Ray\Di\Di\Inject;

class CachedReaderProvider implements Provide
{
    /**
     * @var \Doctrine\Common\Cache\Cache
     */
    private $cache;

    /**
     * @param Cache $cache
     *
     * @Inject
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     *
     * @return CachedReader
     */
    public function get()
    {
        $reader = new CachedReader(new AnnotationReader, $this->cache, true);

        return $reader;
    }
}
