<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use BEAR\Resource\ResourceInterface;
use Ray\Di\Di\Inject;

/**
 * Inject resource client
 *
 * @package    BEAR.Framework
 * @subpackage Inject
 */
trait ResourceInject
{

    /**
     * Set resource
     *
     * @param ResourceInterface $resource
     *
     * @return void
     * @Inject
     */
    public function setResource(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }
}
