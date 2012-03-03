<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Link\View;

use \BEAR\Resource\Object as ResourceObject;

/**
 * Trait for smarty view link.
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
 trait Smarty3
{
    /**
     * @var \Smarty
     */
    private $smarty;

    /**
     * @Inject
     * @Named("Smarty")
     */
    public function setSmarty($smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     * Smarty 3 view link
     *
     * @param ResourceObject $page
     * @return ResourceObject
     */
    public function onLinkView(ResourceObject $page)
    {
        foreach ($page as &$resource) {
            if (is_callable($resource)) {
                $resource = $resource();
            }
        }
        $paegFile = (new \ReflectionClass($page))->getFileName();
        $dir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $this->smarty->assign($page->body);

        $withoutExtention = substr(basename($paegFile), 0 ,strlen(basename($paegFile)) - 3);
        $templateFile =  $dir . DIRECTORY_SEPARATOR . $withoutExtention . 'tpl';
            if (! file_exists($templateFile)) {
            $templateFile =  $dir . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $withoutExtention . 'tpl';
            if (! file_exists($templateFile)) {
                return $page;
            }
        }
        $page->body = $this->smarty->fetch($templateFile);
        return $page;
    }
}
