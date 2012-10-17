<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Resource\CacheControl;

/**
 * Interface for tag
 *
 * @package BEAR.Sunday
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
