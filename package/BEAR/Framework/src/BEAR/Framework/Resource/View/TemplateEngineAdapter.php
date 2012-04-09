<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Resource\View;

interface TemplateEngineAdapter
{
    /**
     * assigns a variable
     *
     * @param array|string $tpl_var the template variable name(s)
     * @param mixed        $value   the value to assign
     *
     * @return self
     */
    public function assign();

    /**
     * fetches a rendered template
     *
     * @param string $template          the resource handle of the template file or template object
     *
     * @return string rendered template output
     */
    public function fetch($template);
}