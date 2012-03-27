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
use BEAR\Framework\Interceptor\ViewAdapter\Render as ViewRenderer;

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
    public function render(Request $request, $resource)
    {
        $class =  ($request->ro instanceof Weave) ? get_class($request->ro->___getObject()) : get_class($request->ro);
        $paegFile = (new \ReflectionClass($class))->getFileName();
        $dir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $this->renderer->assign('resource', $resource);
        if (is_array($resource->body) || $resource->body instanceof \Traversable) {
            $this->renderer->assign($resource->body);
        }
        $templateFileBase = $dir . DIRECTORY_SEPARATOR . substr(basename($paegFile), 0 ,strlen(basename($paegFile)) - 3);
        $resource->body = $this->renderer->fetch($templateFileBase);
        return $resource->body;
    }
}