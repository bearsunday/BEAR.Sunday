<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use BEAR\Resource\ResourceInterface;
use Ray\Di\Di\Inject;

/**
 * Inject resource client
 *
 * @package    BEAR.Sunday
 * @subpackage Inject
 */
trait ResourceInject
{

    /**
     * Set resource
     *
     * @param ResourceInterface $resource
     *
     * @Inject
     */
    public function setResource(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }
}
