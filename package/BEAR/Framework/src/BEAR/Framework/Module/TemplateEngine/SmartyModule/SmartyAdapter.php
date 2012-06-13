<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\TemplateEngine\SmartyModule;

use Smarty;
use BEAR\Framework\Resource\View\TemplateEngineAdapter;
use BEAR\Framework\Exception\TemplateNotFound;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Smarty adapter
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class SmartyAdapter implements TemplateEngineAdapter
{
    /**
     * Renderer
     *
     * @var Smarty
     */
    private $renderer;

    /**
     * Template file
     *
     * @var string
     */
    private $template;

    /**
     * File extention
     *
     * @var string
     */
    const EXT = 'tpl';

    /**
     * Constructor
     * 
     * @Inject
     */
    public function __construct(Smarty $smarty)
    {
        $this->renderer = $smarty;
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Framework\View.Render::assign()
     */
    public function assign()
    {
        $args = func_get_args();
        $count = count($args);
        if ($count === 1) {
            $this->renderer->assign((array)$args[0]);
        } elseif ($count === 2) {
            $this->renderer->assign($args[0], $args[1]);
        } else {
            throw \InvalidArgumentException;
        }
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Framework\View.Render::fetch()
     */
    public function fetch($templateFileBase)
    {
        $template = $templateFileBase . self::EXT;
        $this->fileExists($template);
        $this->template = $template;
        return $this->renderer->fetch($template);
    }

    /**
     * Return file exists
     * 
     * @param string $template
     * 
     * @throws TemplateNotFound
     */
    private function fileExists($template)
    {
        if (! file_exists($template)) {
            throw new TemplateNotFound($template);
        }
    }

    /**
     * Return template full path.
     * 
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->template;
    }
}
