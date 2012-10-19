<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Resource\View;

use BEAR\Resource\Link;
use BEAR\Resource\AbstractObject;
use BEAR\Resource\Requestable;
use BEAR\Resource\Renderable;
use Nocarrier\Hal;

/**
 * Request renderer
 *
 * @package    BEAR.Sunday
 * @subpackage View
 */
class HalRenderer implements Renderable
{
    /**
     * (non-PHPdoc)
     * @see BEAR\Resource.Renderable::render()
     */
    public function render(AbstractObject $ro)
    {
        // evaluate all request in body.
        $isArrayAccess = is_array($ro->body) || $ro->body instanceof \Traversable;
        if ($isArrayAccess) {
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

        // HAL
        $data = $ro->body ?: [];
        if (is_scalar($data)) {
            $data = ['value' => $data];
        }
        $hal = new Hal($ro->uri, $data);
        foreach ($ro->links as $rel => $link) {
            $title = (isset($link[Link::TITLE])) ? $link[Link::TITLE] : null;
            $attr = (isset($link[Link::TEMPLATED]) && $link[Link::TEMPLATED] === true) ? [Link::TEMPLATED => true] : [];
            if (isset($link[Link::HREF])) {
                $hal->addLink($rel, $link[Link::HREF], $title, $attr);
            } else {
                trigger_error('"href" is required in link', E_USER_WARNING);
            }
        }
        $ro->view = $hal->asJson(true);
        $ro->headers['content-type'] = 'application/hal+json; charset=UTF-8';

        return $ro->view;
    }
}
