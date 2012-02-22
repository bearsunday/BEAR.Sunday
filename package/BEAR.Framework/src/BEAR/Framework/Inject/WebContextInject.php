<?php
/**
 * BEAR.Resource;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
use Ray\Di\Definition;

namespace BEAR\Framework\Inject;

use Ray\Di\ProviderInterface as Provider,
    Ray\Di\ConfigInterface,
    Ray\Di\Definition;

/**
 * Inject web context
 */
trait WebContextInject
{
    use DefinitionInject;

    /**
     * @var Aura\Web\Context
     */
    protected $webContext;

    /**
     * Wakeup annotated method(s) with [AT]WakeUp
     */
    public function __wakeup()
    {
        parent::__wakeup();
        $annotations = $this->definition[Definition::BY_NAME];
        if (! isset($annotations['WakeUp'])) {
            return;
        }
        foreach ($annotations['WakeUp'] as $method) {
            $this->$method();
        }
    }

    /**
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
     * @BEAR\Framework\Annotation\WakeUp
     */
    public function setWebContext()
    {
        $this->webContext = $this->contextProvider->get();
    }
}