<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Provide\Router;

use BEAR\Sunday\Extension\Router\RouterInterface;
use BEAR\Sunday\Extension\Router\RouterMatch;
use BEAR\Sunday\Extension\Router\SchemeHost;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class WebRouter implements RouterInterface
{
    /**
     * @var string
     */
    private $schemeHost = 'page://self';

    /**
     * @param SchemeHost $schemeHost default route scheme+host if only path is given
     *
     * @Inject(optional=true)
     */
    public function setSchemeHost(SchemeHost $schemeHost)
    {
        $this->schemeHost = (string) $schemeHost;
    }

    /**
     * {@inheritdoc}
     */
    public function match(array $globals, array $server)
    {
        $request = new RouterMatch;
        $method = strtolower($server['REQUEST_METHOD']);
        list($request->method, $request->path, $request->query) = [
            $method,
            $this->schemeHost . parse_url($server['REQUEST_URI'], PHP_URL_PATH),
            ($method === 'get') ? $globals['_GET'] : $globals['_POST']
        ];

        return $request;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($name, $data)
    {
        return false;
    }
}
