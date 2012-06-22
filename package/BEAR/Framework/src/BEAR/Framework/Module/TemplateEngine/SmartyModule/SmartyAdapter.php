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
     * smarty
     *
     * @var Smarty
     */
    private $smarty;

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
        $this->smarty = $smarty;
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Framework\Resource\View.TemplateEngineAdapter::assign()
     */
    public function assign($tplVar, $value)
    {
        $this->smarty->assign($tplVar, $value);
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Framework\Resource\View.TemplateEngineAdapter::assignAll()
     */
    public function assignAll(array $values)
    {
        $this->smarty->assign($values);
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Framework\View.Render::fetch()
     */
    public function fetch($templatefileWithoutExtention)
    {
        $template = $templatefileWithoutExtention . self::EXT;
        $this->fileExists($template);
        return $this->smarty->fetch($template);
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
