<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Router;

use BEAR\Sunday\Annotation\DefaultSchemeHost;
use BEAR\Sunday\Exception\BadRequestJsonException;
use BEAR\Sunday\Extension\Router\RouterInterface;
use BEAR\Sunday\Extension\Router\RouterMatch;

use function file_get_contents;
use function json_decode;
use function json_last_error;
use function json_last_error_msg;
use function parse_str;
use function parse_url;
use function rtrim;
use function str_contains;
use function strtolower;

use const JSON_ERROR_NONE;
use const PHP_URL_PATH;

/**
 * @psalm-import-type Globals from RouterInterface
 * @psalm-import-type Server from RouterInterface
 */
final class WebRouter implements RouterInterface
{
    public function __construct(
        #[DefaultSchemeHost] private string $schemeHost,
    ) {
    }

    /**
     * {@inheritdoc}
     *
     * @param Globals $globals
     * @param Server  $server
     */
    public function match(array $globals, array $server)
    {
        $method = strtolower($server['REQUEST_METHOD']);

        return new RouterMatch(
            $method,
            $this->schemeHost . parse_url($server['REQUEST_URI'], PHP_URL_PATH),
            $this->getQuery($method, $globals, $server),
        );
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
     * @param Server  $server
     * @param Globals $globals
     *
     * @return array<string, mixed>
     */
    private function getQuery(string $method, array $globals, array $server): array
    {
        if ($method === 'get') {
            return $globals['_GET'];
        }

        if ($method === 'post') {
            return $globals['_POST'];
        }

        $contentType = $server['CONTENT_TYPE'] ?? $server['HTTP_CONTENT_TYPE'] ?? '';
        $isFormUrlEncoded = str_contains($contentType, 'application/x-www-form-urlencoded');
        $rawBody = $server['HTTP_RAW_POST_DATA'] ?? rtrim((string) file_get_contents('php://input'));
        if ($isFormUrlEncoded) {
            parse_str(rtrim($rawBody), $put);

            /** @var array<string, mixed> $put */
            return $put;
        }

        $isApplicationJson = str_contains($contentType, 'application/json');
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
