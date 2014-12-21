<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\Error;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Router\RouterMatch as Request;

interface ErrorInterface
{
    /**
     * @param \Exception $e
     * @param Request    $request
     *
     * @return ResourceObject
     */
    public function handle(\Exception $e, Request $request);
}
