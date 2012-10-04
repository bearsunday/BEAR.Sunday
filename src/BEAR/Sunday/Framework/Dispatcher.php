<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Framework;

use BEAR\Resource\Resource;
use BEAR\Sunday\Application\AppContext;
use Aura\Autoload\Exception\NotReadable;

/**
 * Dispatcher
 *
 * @package    BEAR.Framework
 * @subpackage Framework
 */
class Dispatcher
{
    /**
     * Application context
     *
     * @var AppContext
     */
    private $app;

    /**
     * Constructor
     *
     * @param AppContext $app
     */
    public function __construct(AppContext $app)
    {
        $this->app = $app;
    }

    /**
     * Return resource client and resource object
     *
     * @param string $uri Page resource path ("/hello/world")
     *
     * @return array [BEAR\Resource\ResourceInterface $resource, BEAR\Resource\Object $page]
     * @throws Exception\ResourceNotFound
     */
    public function getInstance($uri)
    {
        $key = 'BEAR_DISPATCH_' . $uri;
        if (apc_exists($key)) {
            list($resource, $page) = apc_fetch($key);

            return [$resource, $page];
        }
        $resource = $this->app->resource;
        try {
            $page = $resource->newInstance($uri);
        } catch (NotReadable $e) {
            try {
                $page = $resource->newInstance($uri . 'index');
            } catch (NotReadable $e) {
                throw new Exception\ResourceNotFound($uri, 404, $e);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        apc_store($key, [$resource, $page]);

        return [$resource, $page];
    }
}
