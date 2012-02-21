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
    foreach ($response->headers as $header) {
        header($header);
    }
    // body
    echo $response->body;

cli:
    $label = "\033[1;32m";
    $label1 = "\033[1;33m";
    $close = "\033[0m";
    if (isset($_SERVER['REQUEST_TIME'])) {
        $response->headers[] = 'X-Request-Per-Second: ' . number_format((1 / (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'])), 2);
        $response->headers[] = 'X-Memory-Peak-Usage: ' . number_format(memory_get_peak_usage(true));
    }
    echo "{$label}[CODE]{$close}{$response->code} {$statusText}" . PHP_EOL;
    foreach ($response->headers as $key => $header) {
        echo "{$label}[HEADER]{$label1} {$key} {$close}{$header}" . PHP_EOL;
    }
    echo "{$label}[BODY]{$close}\n" . $response->body;
    echo PHP_EOL;
