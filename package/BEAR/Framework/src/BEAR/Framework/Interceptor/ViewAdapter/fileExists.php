<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor\ViewAdapter;

use BEAR\Framework\Exception\TemplateNotFound;

/**
 * File exists ?
 *
 * @package    BEAR.Framework
 * @subpackage Interceptor
 */
trait fileExists
{
    private function fileExists($template)
    {
        if (! file_exists($template)) {
            throw new TemplateNotFound($template);
        }
    }
}
