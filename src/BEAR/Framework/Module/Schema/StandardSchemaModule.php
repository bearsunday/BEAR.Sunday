<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Schema;

use Ray\Di\AbstractModule;

/**
 * Schema module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class StandardSchemaModule extends AbstractModule
{
    /**
     * Application module namespace
     *
     * @var string
     */
    private $appModuleNamespace;

    /**
     *
     * @param string $appModuleNamespace
     */
    public function __construct($appModuleNamespace)
    {
        $this->appModuleNamespace = $appModuleNamespace;
        parent::__construct();
    }

    /**
     * Configure SchemeCollectionProvider
     *
     * @return void
     */
    protected function configure()
    {
        $provider = $this->appModuleNamespace . '\SchemeCollectionProvider';
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider($provider);
    }
}
