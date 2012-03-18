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
 * Trait for twig view link.
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
trait Twig
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @Inject
     * @Named("Twig")
     */
    public function setTwig($twig)
    {
        $this->twig = $twig;
    }

    /**
     * Twig view link
     *
     * @param ResourceObject $page
     * @return self
     */
    public function onLinkView(ResourceObject $page)
    {
        $body = [];
        foreach ($page as $key => $resource) {
            if (is_callable($resource)) {
                $resource = $resource();
            }
            $body[$key] = $resource;
        }
        $paegFile = (new \ReflectionClass($page))->getFileName();
        $pageDir = pathinfo($paegFile, PATHINFO_DIRNAME);
        $tmpDir = dirname(dirname(dirname(__DIR__))) . '/tmp/';
        $templateFile = $pageDir . DIRECTORY_SEPARATOR . str_replace('.php', '.twig', basename($paegFile));
        $template = $this->twig->loadTemplate($templateFile);
        $page->body = $template->render($body);
        return $page;
    }
}
