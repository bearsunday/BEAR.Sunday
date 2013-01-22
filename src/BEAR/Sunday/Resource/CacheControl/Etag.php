<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Resource\CacheControl;

use BEAR\Resource\AbstractObject as ResourceObject;

/**
 * Resource Links
 *
 * @package    BEAR.Sunday
 * @subpackage Page
 */
final class Etag implements TagInterface
{
    /**
     * (non-PHPdoc)
     * @see BEAR\Sunday\Resource\CacheControl.TagInterface::getEtag()
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
     * @param string         $tag
     */
    public function tag(ResourceObject $ro, $tag)
    {
        $ro['headers']['etag'] = $tag;
    }
}
