<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Provider;

use Ray\Di\ProviderInterface;
use Aura\Signal\Manager,
    Aura\Signal\HandlerFactory,
    Aura\Signal\ResultFactory,
    Aura\Signal\ResultCollection;

/**
 * Signal
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class SignalProvider implements ProviderInterface
{
    /**
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