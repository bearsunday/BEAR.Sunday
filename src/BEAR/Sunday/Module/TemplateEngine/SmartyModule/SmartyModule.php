<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\TemplateEngine\SmartyModule;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Smarty module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class SmartyModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('Smarty')->toProvider('BEAR\Sunday\Module\TemplateEngine\SmartyModule\SmartyProvider')->in(Scope::SINGLETON);
        $this->bind('BEAR\Sunday\Resource\View\TemplateEngineAdapter')->to('BEAR\Sunday\Module\TemplateEngine\SmartyModule\SmartyAdapter')->in(Scope::SINGLETON);
    }
}
