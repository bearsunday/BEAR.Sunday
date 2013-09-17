<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use Aura\Signal\HandlerFactory;
use Aura\Signal\Manager;
use Aura\Signal\ResultCollection;
use Aura\Signal\ResultFactory;
use Ray\Di\ProviderInterface as Provide;

/**
 * Aura.Signal provider
 *
 * @see https://github.com/auraphp/Aura.Signal.git
 */
class SignalProvider implements Provide
{
    /**
     * {@inheritdoc}
     *
     * @return Manager
     */
    public function get()
    {
        return new Manager(new HandlerFactory, new ResultFactory, new ResultCollection);
    }
}
