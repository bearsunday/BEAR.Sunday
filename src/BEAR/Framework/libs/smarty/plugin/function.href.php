<?php

// use Guzzle\Http\UriTemplate;
use Guzzle\Parser\UriTemplate\UriTemplate;
use BEAR\Framework\Resource\Link;

/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {href} function plugin
 *
 * Type:     function<br>
 * Name:     mailto<br>
 * Date:     May 21, 2002
 * Purpose:  automate mailto address link creation, and optionally encode them.<br>
 * Params:
 * <pre>
 * - address    - (required) - e-mail address
 * - text       - (optional) - text to display, default is address
 * - encode     - (optional) - can be one of:
 * - extra      - (optional) - extra tags for the href link
 * </pre>
 * Examples:
 * <pre>
 * {mailto address="me@domain.com"}
 * {mailto address="me@domain.com" extra='class="mailto"'}
 * </pre>
 *
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 *
 * @return string
 */
function smarty_function_href($params, $template)
{
    if (empty($params['rel'])) {
        trigger_error("href: missing 'rel' parameter", E_USER_WARNING);
        return;
    }
    if (empty($template->smarty->tpl_vars['resource']->value->links[$params['rel']])) {
        trigger_error("href: links needs {$params['rel']} parameter", E_USER_WARNING);
        return;
    }

    $rel = $params['rel'];
    $data = (isset($params['data'])) ? $params['data'] : $template->smarty->tpl_vars['resource']->value->body;
    $resource = $template->smarty->tpl_vars['resource']->value;
    $link = $resource->links[$rel];
    if (isset($link[Link::TEMPLATED]) &&  $link[Link::TEMPLATED] === true) {
        // get expanded url
        $uri = (new UriTemplate)->expand($link[Link::HREF], (array) $data);
    } else {
        $uri = $link[Link::HREF];
    }

    // remove "page://self/"
    $uri = str_replace('page://self/', '/', $uri);
    return $uri;
}