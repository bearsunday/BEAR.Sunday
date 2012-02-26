<?php
/**
 * BEAR.Resource;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use Ray\Di\Definition,
    Ray\Di\ProviderInterface as Provider,
    Ray\Di\ConfigInterface,
    Ray\Di\Definition;

/**
 * Inject web context
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
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