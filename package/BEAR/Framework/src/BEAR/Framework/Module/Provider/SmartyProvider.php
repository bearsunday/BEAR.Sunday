<?php

namespace BEAR\Framework\Module\Provider;

use Ray\Di\InjectorInterface;
use Ray\Di\ProviderInterface;

use Smarty;

/**
 * Smarty3
 *
 * @see http://www.smarty.net/docs/ja/
 */
class SmartyProvider implements ProviderInterface
{
    /**
     * @return array
     */
    public function get()
    {
        $smarty = new Smarty;
        $tmpDir = dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))))) . '/tmp';
        $smarty->setCompileDir($tmpDir . '/smarty/template_c');
        $smarty->setCacheDir($tmpDir . '/smarty/cache');
        return $smarty;
    }
}
