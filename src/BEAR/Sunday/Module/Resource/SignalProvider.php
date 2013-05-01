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
 * Signal provider
 */
class SignalProvider implements Provide
{
    /**
     * Return instance
     *
     * @return Manager
     */
    public function get()
    {
        return new Manager(new HandlerFactory, new ResultFactory, new ResultCollection);
    }
}
