<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use BEAR\Resource\Client as Resource;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Inject resource client
 *
 * @package    BEAR.Framework
 * @subpackage Inject
 */
trait ResourceInject
{

    /**
     * @Inject
     */
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;
    }
}
