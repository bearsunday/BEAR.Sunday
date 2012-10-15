<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Ray\Di\Definition;
use Ray\Di\ProviderInterface as Provider;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Inject web context
 *
 * @package    BEAR.Sunday
 * @subpackage Inject
 */
trait WebContextInject
{
    use DefinitionInject;

    /**
     * @var \Aura\Web\Context
     */
    protected $webContext;

    /**
     * Wakeup annotated method(s) with [AT]WakeUp
     */
    public function __wakeup()
    {
        parent::__wakeup();
        $annotations = $this->definition[Definition::BY_NAME];
        if (!isset($annotations['WakeUp'])) {
            return;
        }
        foreach ($annotations['WakeUp'] as $method) {
            $this->$method();
        }
    }

    /**
     * Set web context provider
     *
     * @param Provider $contextProvider
     *
     * @Inject
     * @Named("webContext")
     */
    public function setWebContextProvider(Provider $contextProvider)
    {
        $this->contextProvider = $contextProvider;
    }

    /**
     * Web context setter on wakeup
     *
     * @BEAR\Sunday\Annotation\WakeUp
     */
    public function setWebContext()
    {
        $this->webContext = $this->contextProvider->get();
    }
}
