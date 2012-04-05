<?php
/**
 *  BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Resource\View;

use Ray\Aop\Weave;

use BEAR\Resource\Renderable;
use BEAR\Resource\Request;
use BEAR\Resource\Object as ResourceObject;
use BEAR\Framework\Interceptor\ViewAdapter\Renderable as ViewRenderer;

/**
 * Request render
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */

class Renderer implements Renderable
{
    private $renderer;

    /**
     * ViewRenderer Setter
     *
     * @param ViewRenderer $renderer
     *
     * @Inject
     */
    public function setRenderer(ViewRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Resource.Renderable::render()
     */
    public function render(ResourceObject $ro)
    {
        $class =  ($ro instanceof Weave) ? get_class($ro->___getObject()) : get_class($ro);
        $paegFile = (new \ReflectionClass($class))->getFileName();
        $dir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $this->renderer->assign('resource', $ro);
        if (is_array($ro->body) || $ro->body instanceof \Traversable) {
            $this->renderer->assign($ro->body);
        }
        $templateFileBase = $dir . DIRECTORY_SEPARATOR . substr(basename($paegFile), 0 ,strlen(basename($paegFile)) - 3);
        $ro->body = $this->renderer->fetch($templateFileBase);
        return $ro->body;
    }
}