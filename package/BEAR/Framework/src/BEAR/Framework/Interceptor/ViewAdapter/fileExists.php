<?php
/**
 *  BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor\ViewAdapter;

use BEAR\Framework\Exception\TemplateNotFound;

/**
 * TraitName
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
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
