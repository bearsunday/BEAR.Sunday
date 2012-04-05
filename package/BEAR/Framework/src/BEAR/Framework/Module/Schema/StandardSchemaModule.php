<?php
/**
 * Module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
namespace BEAR\Framework\Module\Schema;
use Ray\Di\Scope;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;

/**
 * Schema module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class StandardSchemaModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider('\sandbox\Module\SchemeCollectionProvider');
    }
}
