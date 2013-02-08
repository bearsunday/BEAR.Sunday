<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

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
     * @Ray\Di\Di\Inject
     */
    public function setEtag(TagInterface $etag)
    {
        $this->etag = $etag;
    }
}
