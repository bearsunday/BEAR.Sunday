<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Provider;

use Ray\Di\ProviderInterface as Provide;
use Aura\Signal\Manager;
use Aura\Signal\HandlerFactory;
use Aura\Signal\ResultFactory;
use Aura\Signal\ResultCollection;

/**
 * Signal
 *
 * @package    BEAR.Framework
 * @subpackage Module
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
        return new Manager(
            new HandlerFactory,
            new ResultFactory,
            new ResultCollection
        );
    }
}
