<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Json render module
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class JsonModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\Renderable')->to('BEAR\Sunday\Resource\View\JsonRenderer')->in(Scope::SINGLETON);
    }
}
