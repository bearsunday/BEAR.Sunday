<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use BEAR\Resource\ResourceInterface;

/**
 * Inject resource client
 *
 * @package    BEAR.Sunday
 * @subpackage Inject
 */
trait ResourceInject
{
    /**
     * @var ResourceInterface
     */
    protected $resource;

    /**
     * Set resource
     *
     * @param ResourceInterface $resource
     *
     * @Ray\Di\Di\Inject
     */
    public function setResource(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }
}
