<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\Error;

use BEAR\Sunday\Extension\Router\RouterMatch as Request;

interface ErrorInterface
{
    /**
     * Handle exception
     *
     * @param \Exception $e
     * @param Request    $request
     *
     * @return $this
     */
    public function handle(\Exception $e, Request $request);

    /**
     * Error page transfer
     */
    public function transfer();
}
