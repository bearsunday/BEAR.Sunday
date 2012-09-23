<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Database;

use Ray\Di\InjectorInterface;
use Ray\Di\AbstractModule;

/**
 * DBAL module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class DoctrineDbalModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $dbInjector = $this->requestInjection('\BEAR\Framework\Interceptor\DbInjector');
        $this->bindInterceptor(
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\Db'),
            $this->matcher->startWith('on'),
            [$dbInjector]
        );
    }
}
