<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Annotation;

/**
 * DB Pager
 *
 * @Annotation
 * @Target("METHOD")
 *
 * @package    BEAR.Framework
 * @subpackage Annotation
 */
final class DbPager
{
    /**
     * Limit per page
     *
     * @var int
     */
    public $limit = 10;
}
