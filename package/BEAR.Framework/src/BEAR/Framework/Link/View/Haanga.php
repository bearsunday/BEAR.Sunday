<?php
/**
 * BEAR.Resource
 *
 * @license  http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Link\View;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\Request;

require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/vendor/Haanga/lib/Haanga.php';

/**
 * Trait for twig view link.
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
trait Haanga
{
    /**
     * Init on wakeup
     */
    public function __wakeup()
    {
        // Haanga static init
        \Haanga::configure([
                            'template_dir' => '/',
                            'cache_dir' => dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/tmp/'
        ]);
    }

    /**
     * Haanga view link
     *
     * @param ResourceObject $page
     * @return ResourceObject
     */
    public function onLinkView(ResourceObject $page)
    {
        foreach ($page as $key => &$resource) {
            if (is_callable($resource)) {
                $resource = $resource();
            }
        }
        $paegFile = (new \ReflectionClass($page))->getFileName();
        $pageDir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $templateFile = $pageDir . '/view/' . str_replace('.php', '.hng', basename($paegFile));
        $page->body = \Haanga::Load($templateFile, $page->body, true);
        return $page;
    }
}
