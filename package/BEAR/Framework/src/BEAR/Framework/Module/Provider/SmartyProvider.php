<?php

namespace BEAR\Framework\Module\Provider;

use Ray\Di\InjectorInterface;
use Ray\Di\ProviderInterface as Provide;
use BEAR\Framework\Inject\LogInject;
use BEAR\Framework\Inject\TmpDirInject;

use Smarty;

/**
 * Smarty3
 *
 * @see http://www.smarty.net/docs/ja/
 */
class SmartyProvider implements Provide
{
    use LogInject;
    use TmpDirInject;

    /**
     * @return Smarty
     */
    public function get()
    {
        $smarty = new Smarty;
        $smarty->setCompileDir($this->tmpDir . '/smarty/template_c');
        $smarty->setCacheDir($this->tmpDir . '/smarty/cache');
        $this->log->log("Smarty installed.tmp=[{$this->tmpDir}]");
        return $smarty;
    }
}
