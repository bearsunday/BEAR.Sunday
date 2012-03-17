<?php

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
     * @return array
     */
    public function get()
    {
        return new Context($GLOBALS);
    }
}