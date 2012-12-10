<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Resource\View;

use BEAR\Resource\AbstractObject;
use BEAR\Resource\Requestable;
use BEAR\Resource\Renderable;

/**
 * Request renderer
 *
 * @package    BEAR.Sunday
 * @subpackage View
 */
class JsonRenderer implements Renderable
{
    /**
     * (non-PHPdoc)
     * @see BEAR\Resource.Renderable::render()
     */
    public function render(AbstractObject $ro)
    {
        // evaluate all request in body.
        /** @noinspection PhpUndefinedFieldInspection */
        if (is_array($ro->body) || $ro->body instanceof \Traversable) {
            array_walk_recursive(
                $ro->body,
                function (&$element) {
                    if ($element instanceof Requestable) {
                        /** @var $element Callable */
                        $element = $element();
                    }
                }
            );
        }
        $ro->view = @json_encode($ro->body, JSON_PRETTY_PRINT);

        return $ro->view;
    }
}
