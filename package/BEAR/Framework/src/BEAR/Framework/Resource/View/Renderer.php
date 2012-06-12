<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Resource\View;

use Ray\Aop\Weave;
use BEAR\Resource\Object as ResourceObject;
use BEAR\Resource\Renderable;
use ReflectionClass;
use BEAR\Framework\Resource\View\TemplateEngineAdapter;

/**
 * Request renderer
 *
 * @package    BEAR.Framework
 * @subpackage View
 */
class Renderer implements Renderable
{
    /**
     * Template engine adapter
     *
     * @var Templatable
     */
    private $templateEngineAdapter;

    /**
     * ViewRenderer Setter
     *
     * @param TemplateEngineAdapter $templateEngineAdapter
     */
    public function __construct(TemplateEngineAdapter $templateEngineAdapter)
    {
        $this->templateEngineAdapter = $templateEngineAdapter;
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Resource.Renderable::render()
     */
    public function render(ResourceObject $ro)
    {
        $class = ($ro instanceof Weave) ? get_class($ro->___getObject()) : get_class($ro);
        $paegFile = (new ReflectionClass($class))->getFileName();
        $dir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $this->templateEngineAdapter->assign('resource', $ro);
        if (is_array($ro->body) || $ro->body instanceof \Traversable) {
            $this->templateEngineAdapter->assign($ro->body);
        }
        $templateFileBase = $dir . DIRECTORY_SEPARATOR . substr(basename($paegFile), 0, strlen(basename($paegFile)) - 3);
        $ro->body = $this->templateEngineAdapter->fetch($templateFileBase);
        return $ro->body;
    }
}