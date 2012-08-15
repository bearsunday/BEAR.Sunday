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

/**
 * Request renderer
 *
 * @package    BEAR.Framework
 * @subpackage View
 */
class JsonRenderer implements Renderable
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
        $ro->view = @json_encode($ro->body, JSON_PRETTY_PRINT);

        return $ro->view;
    }
}
