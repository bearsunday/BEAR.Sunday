<?php
namespace demowolrd\Annotation;

/**
 * Cache Update
 *
 * @Annotation
 * @Target("METHOD")
 *
 * @package    demoworld
 * @subpackage Annotation
 */
final class CacheUpdate
{
    public $keys = ['id'];
}