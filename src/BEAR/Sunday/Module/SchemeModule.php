<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module;

use Ray\Di\AbstractModule;

/**
 * Scheme module
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
     * @param AbstractModule   $module
     * @param \Ray\Aop\Matcher $schemeProvider
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
