<?php
/**
 * BEAR.Resource;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use BEAR\Resource\Client as Resource;

/**
 * Inject resource client
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
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
