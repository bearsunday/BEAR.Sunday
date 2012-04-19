<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Interceptor\ViewAdapter;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Smarty;

/**
 * Smarty adapter
 *
 * @package    BEAR.Framework
 * @subpackage Intercetor
 */
class SmartyBackend implements Renderable
{
    use fileExists;

    /**
     * @var Smarty
     */
    private $renderer;

    const EXT = 'tpl';

    /**
     * Constructor
     * @Inject
     * @Named("tmp_dir")
     */
    public function __construct($tmpDir)
    {
        $this->tmpDir = $tmpDir;
    }

    /**
     * setRenderer
     *
     * @Inject
     */
    public function setRenderer(Smarty $smarty)
    {
        $this->renderer = $smarty;
        $dir = dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))));
        $this->renderer->setCompileDir($dir . '/tmp/smarty/template_c');
        $this->renderer->setCacheDir($dir. '/tmp/smarty/cache');
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Framework\View.Render::assign()
     */
    public function assign(array $values)
    {
        $this->renderer->assign((array) $values);
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Framework\View.Render::fetch()
     */
    public function fetch($templateFileBase)
    {
        $template = $templateFileBase . self::EXT;
        $this->fileExists($template);
        return $this->renderer->fetch($template);
    }
}
