<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Annotation;

/**
 * Pager
 *
 * @Annotation
 * @Target("METHOD")
 *
 * @package    BEAR.Sunday
 * @subpackage Annotation
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
