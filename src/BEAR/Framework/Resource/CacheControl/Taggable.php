<?php
/**
 *  BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Resource\CacheControl;

/**
 * Taggable
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
interface Taggable
{
    /**
     * Get etag
     *
     * @param object $object
     * @param array  $args
     */
    public function getEtag($object, $args);
}
