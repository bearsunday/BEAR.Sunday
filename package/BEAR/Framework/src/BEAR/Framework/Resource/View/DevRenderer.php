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
use ReflectionObject;
/**
 * Request renderer
 *
 * @package    BEAR.Framework
 * @subpackage View
 */
class DevRenderer implements Renderable
{

    const NO_CACHE = '';
    const WRITE_CACHE = 'label-important';
    const READ_CACHE = 'label-success';

    /**
     * Template engine adapter
     *
     * @var Templatable
     */
    private $templateEngineAdapter;

    /**
     * ViewRenderer Setter
     * 
     * @param ViewRenderer $renderer
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

        $class =  ($ro instanceof Weave) ? get_class($ro->___getObject()) : get_class($ro);
        $paegFile = (new ReflectionClass($class))->getFileName();
        $dir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $this->templateEngineAdapter->assign('resource', $ro);
        if (is_array($ro->body) || $ro->body instanceof \Traversable) {
            $this->templateEngineAdapter->assign($ro->body);
        }
        $templateFileBase = $dir . DIRECTORY_SEPARATOR . substr(basename($paegFile), 0 ,strlen(basename($paegFile)) - 3);
        $body = $this->templateEngineAdapter->fetch($templateFileBase);
        $templateFile = $this->templateEngineAdapter->getTemplateFile();
        $ro->body = $this->getLabel($ro, $templateFile) . "<div style=\"border: 1px dashed gray\">{$body}</div>";
        return $ro->body;
    }

    private function getLabel(ResourceObject $ro, $templateFile)
    {
        if (! isset($ro->headers['x-cache-info'])) {
            $labelColor = self::NO_CACHE;
        } elseif ($ro->headers['x-cache-info']['mode'] === 'W') {
            $labelColor = self::WRITE_CACHE;
        } else {
            $labelColor = self::READ_CACHE;
        }
        $resourceName = ($ro->uri ?: get_class($ro));

        // code editor
        $file = (new ReflectionObject($ro))->getFileName();
        $nameLabel = "<span class=\"label {$labelColor}\">{$resourceName}</span>";
        $codeEditorLink = "<a target=\"_blank\" href=\"/_bear/edit/?file={$file}\">";

        // template
        $templateEditLink = "<a target=\"_blank\" href=\"/_bear/edit/?file={$templateFile}\">";

        $tools = "{$codeEditorLink}<span class=\"icon-edit\"></span></a>";
        $tools .= "{$templateEditLink}<span class=\"icon-file\"></span></a>";
        $tools .= '<span class="icon-zoom-in"></span><span class="icon-font"></span><span class="icon-info-sign"></span>';
        $label =  $nameLabel . '<span class=\"label\" label-success>'. $tools .'</span>';
        return $label;
    }
}