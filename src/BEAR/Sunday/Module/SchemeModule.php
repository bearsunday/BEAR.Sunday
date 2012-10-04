<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module;

use Ray\Di\AbstractModule;

/**
 * Scheme module
 *
 * @package    BEAR.Framework
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
     *
     * @param array $names
     */
    public function __construct($schemeProvider)
    {
        $this->schemeProvider = $schemeProvider;
        parent::__construct();
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider($this->schemeProvider);
    }
}
