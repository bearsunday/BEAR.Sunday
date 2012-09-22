<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Resource\CacheControl;

/**
 * Intaface for tag
 *
 * @package BEAR.Framework
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
