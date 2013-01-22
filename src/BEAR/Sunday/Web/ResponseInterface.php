<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Web;

use \BEAR\Resource\AbstractObject;

/**
 * Interface for http response
 *
 * @package    BEAR.Sunday
 * @subpackage Web
 */
interface ResponseInterface
{
    /**
     * @param $page
     *
     * @return mixed
     */
    public function setResource($page);
}
