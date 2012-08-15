<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\TemplateEngine\SmartyModule;

use Ray\Di\Di\Inject;
use BEAR\Framework\Framework;
use BEAR\Framework\Inject\LogInject;
use BEAR\Framework\Inject\TmpDirInject;
use BEAR\Framework\Inject\AppDirInject;
use Ray\Di\ProviderInterface as Provide;
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
    use AppDirInject;

    /**
     * Return instance
     *
     * @return Smarty
     */
    public function get()
    {
        $smarty = new Smarty;
        $smarty->compile_dir = $this->tmpDir . '/smarty/template_c';
        $smarty->cache_dir = $this->tmpDir . '/smarty/cache';
        $smarty->template_dir = $this->appDir . '/Resource/View';
        $appPlugin = $this->appDir . '/vendor/smarty/plugin/';
        $frameworkPlugin = Framework::$systemRoot . '/src/BEAR/Framework/vendor/smarty/plugin';
        $smarty->plugins_dir = [$smarty->plugins_dir[0], $appPlugin, $frameworkPlugin];
        $this->log->log("Smarty installed.tmp={$this->tmpDir}");

        return $smarty;
    }
}
