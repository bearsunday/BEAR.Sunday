<?php
/**
 * BEAR.Resource
 *
 * @license  http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Link\View;

require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/vendors/Smarty3/libs/Smarty.class.php';

/**
 * Trait for smarty view link.
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
use \BEAR\Resource\Object as ResourceObject;

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
        $pageDir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $this->smarty->assign($page->body);
        $templateFile = $pageDir . '/view/' . str_replace('.php', '.tpl', basename($paegFile));
        $page->body = $this->smarty->fetch($templateFile);
        return $page;
    }
}