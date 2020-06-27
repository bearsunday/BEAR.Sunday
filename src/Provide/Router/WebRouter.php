<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Router;

use BEAR\Sunday\Annotation\DefaultSchemeHost;
use BEAR\Sunday\Exception\BadRequestJsonException;
use BEAR\Sunday\Extension\Router\RouterInterface;
use BEAR\Sunday\Extension\Router\RouterMatch;
use function parse_str;
use function parse_url;
use function strtolower;

/**
 * @psalm-import-type Globals from RouterInterface
 * @psalm-import-type Server from RouterInterface
 */
final class WebRouter implements RouterInterface
{
    /**
     * @var string
     */
    private $schemeHost;

    /**
     * @DefaultSchemeHost
     */
    public function __construct(string $schemeHost)
    {
        $this->schemeHost = $schemeHost;
    }

    /**
     * {@inheritdoc}
     */
    public function match(array $globals, array $server)
    {
        $method = strtolower($server['REQUEST_METHOD']);
        $match = new RouterMatch;
        $match->method = $method;
        $match->path = $this->schemeHost . parse_url($server['REQUEST_URI'], PHP_URL_PATH);
        $match->query = ($method === 'get') ? $globals['_GET'] : $this->getUnsafeQuery($method, $globals, $server);

        return $match;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($name, $data)
    {
        return false;
    }

    /**
     * Return request query by media-type
     *
     * @psalm-param Server $server
     * @psalm-param Globals $globals
     * @phpstan-param array<string, mixed> $globals
     * @phpstan-param array<string, mixed> $server
     *
     * @return array<string, mixed> $globals
     */
    private function getUnsafeQuery(string $method, array $globals, array $server) : array
    {
        if ($method === 'post') {
            return $globals['_POST'];
        }
        $contentType = $server['CONTENT_TYPE'] ?? ($server['HTTP_CONTENT_TYPE']) ?? '';
        $isFormUrlEncoded = strpos($contentType, 'application/x-www-form-urlencoded') !== false;
        $rawBody = $server['HTTP_RAW_POST_DATA'] ?? rtrim((string) file_get_contents('php://input'));
        if ($isFormUrlEncoded) {
            parse_str(rtrim($rawBody), $put);

            /** @var array<string, mixed> $put */
            return $put;
        }
        $isApplicationJson = strpos($contentType, 'application/json') !== false;
        if (! $isApplicationJson) {
            return [];
        }
        /** @var array<string, mixed> $content */
        $content = json_decode($rawBody, true);
        $error = json_last_error();
        if ($error !== JSON_ERROR_NONE) {
            throw new BadRequestJsonException(json_last_error_msg());
        }

        return $content;
    }
}
