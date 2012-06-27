<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Annotation;

/**
 * Pager
 *
 * @Annotation
 * @Target("METHOD")
 *
 * @package    BEAR.Framework
 * @subpackage Annotation
 */
final class DbPager
{
    public $limit = 10;
}
