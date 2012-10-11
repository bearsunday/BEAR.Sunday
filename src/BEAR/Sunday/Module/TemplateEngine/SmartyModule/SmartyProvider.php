<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\TemplateEngine\SmartyModule;

use BEAR\Sunday\Inject\TmpDirInject;
use BEAR\Sunday\Inject\AppDirInject;
use Ray\Di\ProviderInterface as Provide;
use Smarty;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;


// @codingStandardsIgnoreFile

/**
 * Smarty3
 *
 * @see http://www.smarty.net/docs/ja/
 */
class SmartyProvider implements Provide
{
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
        $appPlugin = $this->appDir . '/vendor/libs/smarty/plugin/';
        $frameworkPlugin = dirname(__DIR__) . '/plugin';
        $smarty->plugins_dir = [$smarty->plugins_dir[0], $appPlugin, $frameworkPlugin];

        return $smarty;
    }
}
