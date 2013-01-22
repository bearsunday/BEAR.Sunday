<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use BEAR\Sunday\Resource\CacheControl\TagInterface;
use Ray\Di\Di\Inject;

/**
 * Inject etag tagger
 *
 * @package    BEAR.Sunday
 * @subpackage Inject
 */
trait EtagInject
{
    /**
     * Definition
     *
     * @var TagInterface
     */
    private $etag;

    /**
     * Set etag
     *
     * @param TagInterface $etag
     *
     * @Inject
     */
    public function setEtag(TagInterface $etag)
    {
        $this->etag = $etag;
    }
}
