<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Annotation;

/**
 * Cache
 *
 * @Annotation
 * @Target("METHOD")
 */
final class Cache implements AnnotationInterface
{
    /**
     * Cache time
     *
     * @var integer
     */
    public $time = 0;
}
