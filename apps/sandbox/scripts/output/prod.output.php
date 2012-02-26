<?php
/**
 * Output script for Development
 *
 * @global BEAR\Resource\Object $response
 */
namespace BEAR\Application\Script;

use BEAR\Resource\Code;

$code = new Code;
$statusText =  (isset($code->statusText[$response->code])) ? $code->statusText[$response->code] : '';

if (PHP_SAPI === 'cli') {
    goto cli;
}

web:
    // code
    $protocol = isset($_ENV['SERVER_PROTOCOL']) ? $_ENV['SERVER_PROTOCOL'] : 'HTTP/1.1';
    header("{$protocol} {$response->code} {$statusText}", true, $response->code);
    // header
    foreach ($response->headers as $key => $header) {
        header("{$key}: $header");
    }
    // body
    echo $response->body;
    exit(0);
cli:
    echo "{$response->code} {$statusText} \n";
    foreach ($response->headers as $headerKey => $header) {
        echo "$headerKey: $header\n";
    }
    echo "Content-Length: " . strlen($response->body) . "\n";
    echo "\n" . $response->body;
    echo PHP_EOL;
    exit(0);