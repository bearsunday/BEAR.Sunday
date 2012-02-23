<?php

namespace BEAR\Framework\Module\Provider;

use Ray\Di\ProviderInterface;

use Aura\Signal\Manager,
    Aura\Signal\HandlerFactory,
    Aura\Signal\ResultFactory,
    Aura\Signal\ResultCollection;

/**
 * Signal
 *
 */
class SignalProvider implements ProviderInterface
{
    /**
     * @return Aura\Signal\Manager
     */
    public function get()
    {
        return new Manager(new HandlerFactory, new ResultFactory, new ResultCollection);
    }
}
