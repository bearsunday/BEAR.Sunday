<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Ray\Di\Di\Inject;
use BEAR\Sunday\Resource\CacheControl\Taggable;

/**
 * Inject etag tagger
 *
 * @package    BEAR.Framework
 * @subpackage Inject
 */
trait EtagInject
{
    /**
     * Definition
     *
     * @var \BEAR\Sunday\Resource\CacheControl\Taggable
     */
    private $etag;

    /**
     * Set etag
     *
     * @param Taggable $etag
     *
     * @Inject
     */
    public function setEtag(Taggable $etag)
    {
        $this->etag = $etag;
    }
}
