<?php
namespace demoworld\Annotation;

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