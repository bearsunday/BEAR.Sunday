<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Provider;

use Ray\Di\ProviderInterface;
use Aura\Web\Context;

/**
 * WebContext (Aura.Web)
 *
 * @see https://github.com/auraphp/Aura.Web.git
 */
class WebContextProvider implements ProviderInterface
{
    /**
     * Return instance
     *
     * @return Context
     */
    public function get()
    {
        return new Context($GLOBALS);
    }
}
