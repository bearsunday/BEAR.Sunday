<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Link\View;

use BEAR\Resource\Object as ResourceObject;

/**
 * Trait for php view link
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
trait Php
{
    public function onLinkView(ResourceObject $page)
    {
        foreach ($page as &$resource) {
            if (is_callable($resource)) {
                $resource = $resource();
            }
        }
        $paegFile = (new \ReflectionClass($page))->getFileName();
        $dir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $templateFile = $dir . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . basename($paegFile);
        if (! file_exists($templateFile)) {
            $withoutExtension = substr(basename($paegFile), 0 ,strlen(basename($paegFile)) - 3);
            $templateFile =  $dir . DIRECTORY_SEPARATOR . $withoutExtension . 'tpl.php';
            if (! file_exists($templateFile)) {
                return $page;
            }
        }
        ob_start();
        include $templateFile;
        $body = ob_get_clean();
        $page->body = $body;
        return $page;
    }
}