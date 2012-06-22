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
use Ray\Di\Di\Inject;

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
     * 
     * @Inject
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
        $file = (new ReflectionClass($class))->getFileName();
        
        // assign 'resource'
        $this->templateEngineAdapter->assign('resource', $ro);

        // assign all
        if (is_array($ro->body) || $ro->body instanceof \Traversable) {
            $this->templateEngineAdapter->assignAll((array)$ro->body);
        }
        $templatefileWithoutExtention = substr($file, 0, -3);
        $ro->body = $this->templateEngineAdapter->fetch($templatefileWithoutExtention);
        return $ro->body;
    }
}