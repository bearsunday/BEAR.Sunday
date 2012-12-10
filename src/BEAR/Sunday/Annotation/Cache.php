<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Annotation;

/**
 * Cache
 *
 * @Annotation
 * @Target("METHOD")
 *
 * @package    BEAR.Sunday
 * @subpackage Annotation
 */
final class Cache implements Annotation
{
    /**
     * Cache time
     *
     * @var integer
     */
    public $time = false;
}
