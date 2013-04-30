<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Cqrs\Interceptor;

/**
 * EtagTrait
 */
trait EtagTrait
{
    /**
     * @param $object
     * @param $args
     *
     * @return int
     */
    public function getEtag($object, $args)
    {
        $etag = crc32(get_class($object) . serialize($args));

        return $etag;
    }
}
