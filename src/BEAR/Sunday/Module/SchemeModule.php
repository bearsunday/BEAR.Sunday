<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module;

use Ray\Di\AbstractModule;

/**
 * Scheme module
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class SchemeModule extends AbstractModule
{
    /**
     * Scheme collection provider
     *
     * @var string
     */
    private $schemeProvider;

    /**
     * Constructor
     *
     * @param string $schemeProvider provider class name
     */
    public function __construct(AbstractModule $module, $schemeProvider)
    {
        $this->schemeProvider = $schemeProvider;
        parent::__construct($module);
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\SchemeCollectionInterface')->toProvider($this->schemeProvider);
    }
}
