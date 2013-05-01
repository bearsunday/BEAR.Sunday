<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Exception;

use BEAR\Resource\Exception;

/**
 * Not found exception
 *
 * @subpackge Exception
 */
class ResourceNotFound extends \BadMethodCallException implements ExceptionInterface
{
}
