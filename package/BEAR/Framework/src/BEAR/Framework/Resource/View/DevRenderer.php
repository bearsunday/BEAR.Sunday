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
use BEAR\Resource\Request;
use ReflectionClass;
use BEAR\Framework\Resource\View\TemplateEngineAdapter;
use ReflectionObject;
use Ray\Di\Di\Inject;
use DateTime;
use DateInterval;

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
    
    const BADGE_ARGS = '<span class="badge badge-info">Arguments</span>';
    const BADGE_CACHE = '<span class="badge badge-info">Cache</span>';
    const BADGE_INTERCEPTORS = '<span class="badge badge-info">Interceptors</span>';
    
    const ICON_LIFE = '<span class="icon-refresh"></span>';
    const ICON_TIME = '<span class="icon-time"></span>';
    const ICON_NA = '<span class="icon-ban-circle"></span>';

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
        // resource code editor
        $class =  get_class($ro);
        $paegFile = (new ReflectionClass($class))->getFileName();

        // resource template editor
        $dir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $this->templateEngineAdapter->assign('resource', $ro);
        if (is_array($ro->body) || $ro->body instanceof \Traversable) {
            $this->templateEngineAdapter->assign($ro->body);
        }
        $templateFileBase = $dir . DIRECTORY_SEPARATOR . substr(basename($paegFile), 0 ,strlen(basename($paegFile)) - 3);

        // add tools
        $body = $this->templateEngineAdapter->fetch($templateFileBase);
        $body = $this->addJsDevToolLadingHtml($body);
        $templateFile = $this->templateEngineAdapter->getTemplateFile();
        $ro->body = $this->getLabel($body, $ro, $templateFile);
        return $ro->body;
    }

    private function addJsDevToolLadingHtml($body)
    {
        $replace = <<<EOT
<!-- BEAR.Sunday dev renderer -->
<script src="/_bear/css/bear.css"></script>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap-tooltip.js"></script>
<script src="/assets/js/bootstrap-popover.js"></script>
<script src="/assets/js/bootstrap-collapse.js"></script>
<script src="/assets/js/bootstrap-tab.js"></script>
<script>
$(function(){
    jQuery.noConflict();
    jQuery('[rel=tooltip]').tooltip();
    jQuery('[rel=popover]').popover();
    jQuery('#toolTab a:first').tab('show')
});
</script>
<!-- /BEAR.Sunday dev renderer -->
</body>
EOT;
        $body = str_replace('</body>', $replace, $body);
        return $body;
    }

    private function getLabel($body, ResourceObject $ro, $templateFile)
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
        $codeFile = (new ReflectionObject($ro))->getFileName();

        // var
        $var = $this->getVar($ro->body);
        $resourceKey = spl_object_hash($ro);
        $html = highlight_string($body, true);

        $info = $this->getResourceMetaInfo($ro);

        $label = <<<EOT
<span class="label {$labelColor}">{$resourceName}</span>
    <a data-toggle="tab" href="#{$resourceKey}_body"><span class="icon-home" rel="tooltip" title="Home"></span></a>
    <a data-toggle="tab" href="#{$resourceKey}_var"><span class="icon-zoom-in" rel="tooltip" title="Status"></span></a>
    <a data-toggle="tab" href="#{$resourceKey}_html"><span class="icon-font" rel="tooltip" title="View"></span></a>
    <a data-toggle="tab" href="#{$resourceKey}_info"><span class="icon-info-sign" rel="tooltip" title="Info"></span></a>
    <span style="padding:4px;"></span>
    <a target="_blank" href="/_bear/edit/?file={$codeFile}"><span class="icon-edit" rel="tooltip" title="Code ({$codeFile})"></span></a>
    <a target="_blank" href="/_bear/edit/?file={$templateFile}"><span class="icon-file" rel="tooltip" title="Template ({$templateFile})"></span></a>
    </span>
<div id="myTabContent" class="tab-content">
<div id="{$resourceKey}_body" class="tab-pane fade active in"><div style="border: 1px dashed gray">{$body}</div></div>
<div id="{$resourceKey}_var" class="tab-pane fade active"><div class="well"><div class="badge badge-info">Resource state</div>{$var}</div></div>
<div id="{$resourceKey}_html" class="tab-pane fade"><div class="well"><div class="badge badge-info">Resource representation</div>{$html}</div></div>
<div id="{$resourceKey}_info" class="tab-pane fade"><div class="well">{$info}</div></div>
</div>
EOT;
        return $label;
    }

    private function getVar($body)
    {
        if (is_scalar($body)) {
            return $body;
        }
        $isTraversable = (is_array($body) || $body instanceof \Traversable);
        if (! $isTraversable) {
            return '-';
        }
        array_walk_recursive($body, function(&$value) {
            if ($value instanceof Request) {
                $value = '(Request)' . $value->toUri();
            }
            if ($value instanceof ResourceObject) {
                $value = $value->body;
            }
            if (is_object($value)) {
                $value = '(object)' . get_class($value);
            }
        });
        return highlight_string(var_export($body, true), true);
    }

    /**
     * Return resource meta info
     *
     * @param ResourceObject $ro
     *
     * @return string
     */
    private function getResourceMetaInfo(ResourceObject $ro)
    {
        $info = $this->getArgsInfo($ro);
        $info .= $this->getInterceptorInfo($ro);
        $info .= $this->getCacheInfo($ro);
        return $info;
    }

    /**
     * Return method invocation arguments info
     *
     * @param ResourceObject $ro
     */
    private function getArgsInfo(ResourceObject $ro)
    {
        if (! isset($ro->headers['x-args'])) {
            return self::BADGE_ARGS . '<li> n/a (no logger is binded.)</li>';
        }
        $result = self::BADGE_ARGS;
        $args = $ro->headers['x-args'];
        foreach ($args as $arg) {
            if (is_scalar($arg)) {
                $type = gettype($arg);
            } elseif (is_object($arg)) {
                $type = get_class($arg);
            } elseif (is_array($arg)) {
                $type = 'array';
                $arg = print_r($arg, true);
            } else {
                $type = 'unkonwn';
            }
            $argInfo = "<li>($type) {$arg}</li>";
        }
        if ($args === []) {
            $argInfo = '<li>void</li>';
        }
        $result .= "<ul>{$argInfo}</ul>";
        return $result;
    }
    /**
     * Return cache info
     *
     * @param ResourceObject $ro
     */
    private function getCacheInfo(ResourceObject $ro)
    {
        if (! isset($ro->headers['x-cache'])) {
            return self::BADGE_CACHE . '<ul><li> n/a</li></ul>';
        }
        $iconLife = self::ICON_LIFE;
        $iconTime = self::ICON_TIME;
        
        $cache = $ro->headers['x-cache'];
        $life = $cache['life'] ? "{$cache['life']} sec" : 'Unlmited';
        $result = self::BADGE_CACHE . '<ul>';
        if ($cache['mode'] === 'W') {
            $result .=  "Write {$iconLife} {$life}";
        } else {
            if ($cache['life'] === false) {
                $time = $cache['date'];
            } else {
                $created = new DateTime($cache['date']);
                $interval = new DateInterval("PT{$cache['life']}S");
                $expire = $created->add($interval);
                $time = $expire->diff(new DateTime('now'))->format('%h hours %i min %s sec left');
            }
            $result .= "Read {$iconLife} {$life} {$iconTime} {$time}";
        }
        return $result;
    }

    /**
     * Return resource meta info
     *
     * @param ResourceObject $ro
     *
     * @return string
     */
    private function getInterceptorInfo(ResourceObject $ro)
    {
        $result = self::BADGE_INTERCEPTORS;
        if (! isset($ro->headers['x-bind'])) {
            return $result . '<ul><li> n/a</li></ul>';
        }
        $result .= '<ul>';
        foreach ($ro->headers['x-bind'] as $interceptor) {
            $interceptorfile = (new ReflectionClass($interceptor))->getFileName();
            $result .= <<<EOT
<li><a target="_blank" href="/_bear/edit/?file={$interceptorfile}"><span class="icon-arrow-right"></span>{$interceptor}</a></li>
EOT;
        }
        $result .= '</ul>';
        return $result;
    }
}