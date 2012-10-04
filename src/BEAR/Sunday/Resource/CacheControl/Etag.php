<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Resource\CacheControl;

use BEAR\Resource\Object as ResourceObject;

/**
 * Resource Links
 *
 * @package    BEAR.Framework
 * @subpackage Page
 */
final class Etag implements Taggable
{
    /**
     * (non-PHPdoc)
     * @see BEAR\Sunday\Resource\CacheControl.Taggable::getEtag()
     */
    public function getEtag($object, $args)
    {
        $etag = crc32(get_class($object) . serialize($args));

        return $etag;
    }

    /**
     * Tagging
     *
     * @param ResourceObject $ro
     * @param unknown_type   $tag
     */
    public function tag(ResourceObject $ro, $tag)
    {
        $this->ro['headers']['etag'] = $tag;
    }
}
