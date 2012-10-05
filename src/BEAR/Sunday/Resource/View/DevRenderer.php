<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Resource\View;

use BEAR\Resource\Object as ResourceObject;
use BEAR\Resource\Renderable;
use BEAR\Resource\Request;
use BEAR\Resource\DevInvoker;
use BEAR\Sunday\Resource\View\TemplateEngineAdapter;
use BEAR\Sunday\Interceptor\CacheLoader;
use BEAR\Sunday\Framework\Framework;
use ReflectionClass;
use ReflectionObject;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use DateTime;
use DateInterval;
use Traversable;

/**
 * Request renderer
 *
 * @package    BEAR.Framework
 * @subpackage View
 * @SuppressWarnings(PHPMD)
 */
class DevRenderer implements Renderable
{
    const NO_CACHE = '';
    const WRITE_CACHE = 'label-important';
    const READ_CACHE = 'label-success';

    const BADGE_ARGS = '<span class="badge badge-info">Arguments</span>';
    const BADGE_CACHE = '<span class="badge badge-info">Cache</span>';
    const BADGE_INTERCEPTORS = '<span class="badge badge-info">Interceptors</span>';
    const BADGE_PROFILE = '<span class="badge badge-info">Profile</span>';

    const ICON_LIFE = '<span class="icon-refresh"></span>';
    const ICON_TIME = '<span class="icon-time"></span>';
    const ICON_NA = '<span class="icon-ban-circle"></span>';

    const DIV_WELL = '<div style="padding:10px;">';

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
        if (PHP_SAPI === 'cli') {
            // delegate original method to avoid render dev html.
            return (new Renderer($this->templateEngineAdapter))->render($ro);
        }
        // resource code editor
        $class = get_class($ro);
        $paegFile = (new ReflectionClass($class))->getFileName();

        // resource template editor
        $dir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $this->templateEngineAdapter->assign('resource', $ro);
        if (is_array($ro->body) || $ro->body instanceof Traversable) {
            $this->templateEngineAdapter->assignAll($ro->body);
        }
        $templateFileBase = $dir . DIRECTORY_SEPARATOR . substr(basename($paegFile), 0, strlen(basename($paegFile)) - 3);

        // add tool bar
        $ro->view  = $body = $this->templateEngineAdapter->fetch($templateFileBase);
        $body = $this->addJsDevToolLadingHtml($body);
        $templateFile = $this->templateEngineAdapter->getTemplateFile();
        $templateFile = $this->makeRelativePath($templateFile);
        $label = $this->getLabel($body, $ro, $templateFile);

        return $label;
    }

    /**
     * Get relatvive path from system root.
     *
     * @param string $file
     */
    private function makeRelativePath($file)
    {
        $file = str_replace(Framework::$systemRoot, '', $file);
        return $file;
    }
    /**
     * Return JS install html for dev tool
     *
     * @param string $body
     *
     * @return string
     */
    private function addJsDevToolLadingHtml($body)
    {
        if (strpos($body, '</body>') === false) {
            return $body;
        }
        $bootstrapCss = strpos($body, '/assets/css/bootstrap.css') ? '' : '<link href="/assets/css/bootstrap.css" rel="stylesheet">';
        $tooltipJs = strpos($body, '/assets/js/bootstrap-tooltip.js') ? '' : '<script src="/assets/js/bootstrap-tooltip.js"></script>';
        $popoverJs = strpos($body, '/assets/js/bootstrap-popover.js') ? '' : '<script src="/assets/js/bootstrap-popover.js"></script>';
        $collapseJs = strpos($body, '/assets/js/bootstrap-collapse.js') ? '' : '<script src="/assets/js/bootstrap-collapse.js"></script>';
        $tabJs = strpos($body, '/assets/js/bootstrap-tab.js') ? '' : '<script src="/assets/js/bootstrap-tab.js"></script>';
        $toolLoad = <<<EOT
<!-- BEAR.Sunday dev tool load -->
<script src="http://www.google.com/jsapi"></script>
<script>
if (typeof jQuery == "undefined") {
    google.load("jquery", "1.7.1");
}
</script>
{$bootstrapCss}{$tooltipJs}{$popoverJs}{$collapseJs}{$tabJs}
<script>
$(function(){
  jQuery.noConflict();
  jQuery('[rel=tooltip]').tooltip();
  jQuery('[rel=popover]').popover();
  jQuery('.home').click();
});
</script>
<!-- /BEAR.Sunday dev tool load -->
</body>
EOT;
        $toolLoad = str_replace(["\n", "  "], '', $toolLoad);
        $body = str_replace('</html>', "{$toolLoad}\n</html>", $body);
        // $body = $body .  $toolLoad;
        return $body;
    }

    /**
     * Return label
     *
     * @param string         $body
     * @param ResourceObject $ro
     * @param string         $templateFile
     *
     * @return string
     */
    private function getLabel($body, ResourceObject $ro, $templateFile)
    {
        $cache = isset($ro->headers[CacheLoader::HEADER_CACHE]) ? json_decode($ro->headers[CacheLoader::HEADER_CACHE], true) : false;
        if ($cache === false) {
            $labelColor = self::NO_CACHE;
        } elseif ($cache['mode'] === 'W') {
            $labelColor = self::WRITE_CACHE;
        } else {
            $labelColor = self::READ_CACHE;
        }
        $resourceName = ($ro->uri ?: get_class($ro));

        // code editor
        $codeFile = (new ReflectionObject($ro))->getFileName();
        $codeFile = $this->makeRelativePath($codeFile);

        // var
        $var = $this->getVar($ro->body);
        $resourceKey = spl_object_hash($ro);
        $html = highlight_string($body, true);

        $info = $this->getResourceInfo($ro);
        $rmReturn = function ($str) {
            return str_replace("\n", '', $str);
        };
        $result = <<<EOT
<!-- {$resourceName} -->
<span class="label {$labelColor}">{$resourceName}</span>
  <a data-toggle="tab" href="#{$resourceKey}_body" class="home"><span class="icon-home" rel="tooltip" title="Home"></span></a>
  <a data-toggle="tab" href="#{$resourceKey}_var"><span class="icon-zoom-in" rel="tooltip" title="Status"></span></a>
  <a data-toggle="tab" href="#{$resourceKey}_html"><span class="icon-font" rel="tooltip" title="View"></span></a>
  <a data-toggle="tab" href="#{$resourceKey}_info"><span class="icon-info-sign" rel="tooltip" title="Info"></span></a>
<span style="padding:4px;"></span>
  <a target="_blank" href="/_dev/edit/?file={$codeFile}"><span class="icon-edit" rel="tooltip" title="Code ({$codeFile})"></span></a>
  <a target="_blank" href="/_dev/edit/?file={$templateFile}"><span class="icon-file" rel="tooltip" title="Template ({$templateFile})"></span></a>
</span>
<div class="tab-content">
  <div id="{$resourceKey}_body" class="tab-pane fade active in"><div style="border: 1px dashed gray">
EOT;
        $result = $rmReturn($result);
        $result .= $body;
        $label = <<<EOT
<!-- /{$resourceName} --></div></div>
  <div id="{$resourceKey}_var" class="tab-pane fade active"><div class="well"><div class="badge badge-info">Resource state</div>{$var}</div></div>
  <div id="{$resourceKey}_html" class="tab-pane fade"><div class="well"><div class="badge badge-info">Resource representation</div>{$html}</div></div>
  <div id="{$resourceKey}_info" class="tab-pane fade"><div class="well">{$info}</div></div>
</div>
EOT;
        $result .= $rmReturn($label);

        return $result;
    }

    /**
     * Return var
     *
     * @param mixed $body
     */
    private function getVar($body)
    {
        if (is_scalar($body)) {
            return $body;
        }
        $isTraversable = (is_array($body) || $body instanceof Traversable);
        if (! $isTraversable) {
            return '-';
        }
        array_walk_recursive(
            $body,
            function (&$value) {
                if ($value instanceof Request) {
                    $value = '(Request)' . $value->toUri();
                }
                if ($value instanceof ResourceObject) {
                    $value = $value->body;
                }
                if (is_object($value)) {
                    $value = '(object) ' . get_class($value);
                }
            }
        );

        return highlight_string(var_export($body, true), true);
    }

    /**
     * Return resource meta info
     *
     * @param ResourceObject $ro
     *
     * @return string
     */
    private function getResourceInfo(ResourceObject $ro)
    {
        $info = $this->getParamsInfo($ro);
        $info .= $this->getInterceptorInfo($ro);
        $info .= $this->getCacheInfo($ro);
        $info .= $this->getProfileInfo($ro);

        return $info;
    }

    /**
     * Return method invocation arguments info
     *
     * @param ResourceObject $ro
     */
    private function getParamsInfo(ResourceObject $ro)
    {
        $result = self::BADGE_ARGS . self::DIV_WELL;
        if (isset($ro->headers[DevInvoker::HEADER_PARAMS])) {
            $params = json_decode($ro->headers[DevInvoker::HEADER_PARAMS], true);
        } else {
            $params = [];
        }
        foreach ($params as $param) {
            if (is_scalar($param)) {
                $type = gettype($param);
            } elseif (is_object($param)) {
                $type = get_class($param);
            } elseif (is_array($param)) {
                $type = 'array';
                $param = print_r($param, true);
            } elseif (is_null($param)) {
                $type = 'null';
            } else {
                $type = 'unkonwn';
            }
            $param = htmlspecialchars($param, ENT_QUOTES, "UTF-8");
            $paramInfo = "<li>($type) {$param}</li>";
        }
        if ($params === []) {
            $paramInfo = 'void';
        }
        $result .= "<ul>{$paramInfo}</ul>";

        return $result . '</div>';
    }
    /**
     * Return cache info
     *
     * @param ResourceObject $ro
     */
    private function getCacheInfo(ResourceObject $ro)
    {
        $cache = isset($ro->headers[CacheLoader::HEADER_CACHE]) ? json_decode($ro->headers[CacheLoader::HEADER_CACHE], true) : false;
        $result = self::BADGE_CACHE . self::DIV_WELL;
        if ($cache === false) {
            return $result . 'n/a' . '</div>';
        }
        $iconLife = self::ICON_LIFE;
        $iconTime = self::ICON_TIME;

        $life = $cache['life'] ? "{$cache['life']} sec" : 'Unlmited';
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

        return $result . '</div>';
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
        $result = self::BADGE_INTERCEPTORS . self::DIV_WELL;
        if (! isset($ro->headers[DevInvoker::HEADER_INTERCEPTORS])) {
            return $result . 'n/a</div>';
        }
        $result .= '<ul class="unstyled">';
        $interceptors = json_decode($ro->headers[DevInvoker::HEADER_INTERCEPTORS], true);
        $onGetInterceptors = isset($interceptors['onGet']) ? $interceptors['onGet'] : [];
        foreach ($onGetInterceptors as $interceptor) {
            $interceptorfile = (new ReflectionClass($interceptor))->getFileName();
            $interceptorfile = $this->makeRelativePath($interceptorfile);
            $result .= <<<EOT
<li><a target="_blank" href="/_dev/edit/?file={$interceptorfile}"><span class="icon-arrow-right"></span>{$interceptor}</a></li>
EOT;
        }
        $result .= '</ul></div>';

        return $result;
    }

    /**
     * Return resource meta info
     *
     * @param ResourceObject $ro
     *
     * @return string
     */
    private function getProfileInfo(ResourceObject $ro)
    {
        // memory, time
        $result = self::BADGE_PROFILE  . self::DIV_WELL;
        $time = number_format($ro->headers[DevInvoker::HEADER_EXECUTION_TIME], 3);
        $memory = number_format($ro->headers[DevInvoker::HEADER_MEMORY_USAGE]);
        $result .= <<<EOT
<span class="icon-time"></span> {$time} sec <span class="icon-signal"></span> {$memory} bytes
EOT;
        // profile id
        if (isset($ro->headers[DevInvoker::HEADER_PROFILE_ID])) {
            $profileId = $ro->headers[DevInvoker::HEADER_PROFILE_ID];
            $result .= <<<EOT
<span class="icon-random"></span><a href="/_dev/xhprof_html/index.php?run={$profileId}&source=resource"> {$profileId}</a>
EOT;
        }
        $result .= '</div>';

        return $result;
    }
}
