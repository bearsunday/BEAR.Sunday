<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use BEAR\Resource\Module\ResourceModule as BearResourceModule;

class ResourceModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\LoggerInterface')->to('BEAR\Resource\Logger')->in(Scope::SINGLETON);
        $this->install(new BearResourceModule(''));
    }
}
