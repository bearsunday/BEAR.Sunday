<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Annotation;

/**
 * Cache
 *
 * @Annotation
 * @Target("METHOD")
 *
 * @package    BEAR.Framework
 * @subpackage Annotation
 */
final class Cache
{
    /**
     * Cache time
     *
     * @var integer
     */
    public $time = false;
}
