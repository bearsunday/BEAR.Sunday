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
        list($request->method, $request->path, $request->query) = [
            $globals['_SERVER']['REQUEST_METHOD'],
            'page://self' . $globals['_SERVER']['REQUEST_URI'],
            $globals['_SERVER']['REQUEST_METHOD'] === 'GET' ? $globals['_GET'] : $globals['_POST']
        ];

        return $request;
    }
}
