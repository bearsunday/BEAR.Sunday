<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Annotation;

/**
 * Repository
 *
 * @Annotation
 * @Target("METHOD")
 */
final class Repository implements AnnotationInterface
{
    /**
     * Id
     *
     * @var string
     */
    public $id = '';

    /**
     * Type
     *
     * @var string
     */
    public $type = 'db';
}
