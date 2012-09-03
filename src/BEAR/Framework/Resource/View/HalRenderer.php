<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Resource\View;

use BEAR\Resource\Object as ResourceObject;
use BEAR\Resource\Requestable;
use BEAR\Resource\Renderable;
use Nocarrier\Hal;

/**
 * Request renderer
 *
 * @package    BEAR.Framework
 * @subpackage View
 */
class HalRenderer implements Renderable
{
    /**
     * (non-PHPdoc)
     * @see BEAR\Resource.Renderable::render()
     */
    public function render(ResourceObject $ro)
    {
        // evaluate all request in body.
        if (is_array($ro->body) || $ro->body instanceof \Traversable) {
            array_walk_recursive($ro->body, function(&$element) {
                if ($element instanceof Requestable) {
                    $element = $element();
                }
            });
        }

        // HAL
        $hal = new Hal($ro->uri, $ro->body);
        foreach ($ro->links as $rel => $uri) {
            $hal->addLink($rel, $uri);
        }
        $ro->view = $hal->asJson(true);
        return $ro->view;
    }
}
