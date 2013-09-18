<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\WebContext;

use Aura\Web\Context;
use Ray\Di\ProviderInterface;

class WebContextProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     *
     * @return Context
     */
    public function get()
    {
        return new Context($GLOBALS);
    }
}
