<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\WebResponse;

use BEAR\Sunday\Extension\ExtensionInterface;


/**
 * Interface for http response
 *
 * @package    BEAR.Sunday
 * @subpackage Web
 */
interface ResponseInterface extends ExtensionInterface
{
    /**
     * @param $page
     *
     * @return mixed
     */
    public function setResource($page);
}
