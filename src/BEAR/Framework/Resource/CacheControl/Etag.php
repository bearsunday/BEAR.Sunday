<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Resource\CacheControl;

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
     * @see BEAR\Framework\Resource\CacheControl.Taggable::getEtag()
     */
    public function getEtag($object, $args)
    {
        $etag = crc32(get_class($object) . serialize($args));

        return $etag;
    }

    public function tag(ResourceObject $ro, $tag)
    {
        $this->ro['headers']['etag'] = $tag;
    }
}
