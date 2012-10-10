<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Resource\View;

/**
 * Interface for template engine adapter
 *
 * @package    BEAR.Sunday
 * @subpackage Resource
 */
interface TemplateEngineAdapter
{
    /**
     * Assigns a variable
     *
     * @param string $tplVar the template variable name(s)
     * @param mixed  $value  the value to assign
     *
     * @return self
     */
    public function assign($tplVar, $value);

    /**
     * Assigns all variables
     *
     * @param array $values
     *
     * @return self
     */
    public function assignAll(array $values);

    /**
     * Fetches a rendered template
     *
     * @param string $template the resource handle of the template file or template object
     *
     * @return string rendered template output
     */
    public function fetch($template);
}
