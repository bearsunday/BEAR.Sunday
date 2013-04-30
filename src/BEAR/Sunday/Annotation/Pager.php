<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Annotation;

/**
 * Pager
 *
 * @Annotation
 * @Target("METHOD")
 */
final class Pager implements AnnotationInterface
{
    /**
     * Limit per page
     *
     * @var int
     */
    public $limit = 10;
}
