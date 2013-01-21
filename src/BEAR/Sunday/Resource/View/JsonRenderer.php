<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Resource\View;

use BEAR\Resource\AbstractObject;
use BEAR\Resource\RequestInterface;
use BEAR\Resource\RenderInterface;

/**
 * Request renderer
 *
 * @package    BEAR.Sunday
 * @subpackage View
 */
class JsonRenderer implements RenderInterface
{
    /**
     * (non-PHPdoc)
     * @see BEAR\Resource.RenderInterface::render()
     */
    public function render(AbstractObject $ro)
    {
        // evaluate all request in body.
        /** @noinspection PhpUndefinedFieldInspection */
        if (is_array($ro->body) || $ro->body instanceof \Traversable) {
            array_walk_recursive(
                $ro->body,
                function (&$element) {
                    if ($element instanceof RequestInterface) {
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
