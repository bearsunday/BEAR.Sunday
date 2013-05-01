<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\WebResponse;

use BEAR\Sunday\Extension\ExtensionInterface;

/**
 * Interface for http response
 */
interface ResponseInterface extends ExtensionInterface
{
    /**
     * @param $page
     *
     * @return self
     */
    public function setResource($page);

    /**
     * Render resource
     *
     * @return self
     */
    public function render();

    /**
     * Send transfer
     *
     * @return self
     */
    public function send();
}
