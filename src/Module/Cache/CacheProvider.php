<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Cache;

use BEAR\Sunday\Inject\TmpDirInject;
use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\FilesystemCache;
use Ray\Di\ProviderInterface;

class CacheProvider implements ProviderInterface
{
    use TmpDirInject;

    /**
     * Return instance
     *
     * @return \Doctrine\Common\Cache\Cache
     */

    /**
     * {@inheritdoc}
     *
     * @return ApcCache|FilesystemCache
     */
    public function get()
    {
        $loaded = extension_loaded('apc') || extension_loaded('apcu');
        if ($loaded && ini_get('apc.enabled')) {
            return new ApcCache;
        }

        return new FilesystemCache($this->tmpDir . '/cache');
    }
}
