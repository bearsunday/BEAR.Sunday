<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Provide\Router;

use BEAR\Sunday\Extension\Router\RouterInterface;
use BEAR\Sunday\Extension\Router\RouterMatch;

class WebRouter implements RouterInterface
{
    /**
     * {@inheritdoc}
     */
    public function match(array $globals = [])
    {
        $request = new RouterMatch;
        $method = strtolower($globals['_SERVER']['REQUEST_METHOD']);
        list($request->method, $request->path, $request->query) = [
            $method,
            'page://self' . parse_url($globals['_SERVER']['REQUEST_URI'], PHP_URL_PATH),
            ($method === 'get') ? $globals['_GET'] : $globals['_POST']
        ];

        return $request;
    }
}
