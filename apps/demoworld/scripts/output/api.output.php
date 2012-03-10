<?php
/**
 * API Output
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
    header("{$_ENV['SERVER_PROTOCOL']} {$response->code} {$statusText}", true, $response->code);
    // header
    foreach ($response->headers as $header) {
        header($header);
    }
    // body
    echo $response->body;
    exit(0);
cli:
    $label = "\033[1;32m";
    $label1 = "\033[1;33m";
    $label2 = "\033[1;34m";
    $close = "\033[0m";
    if (isset($appStart)) {
        $response->headers[] = 'X-Request-Per-Second: ' . (int)(1 / (microtime(true) - $appStart));
        $response->headers[] = 'X-Memory-Peak-Usage: ' . number_format(memory_get_peak_usage(true));
    }
    echo "{$label}[CODE]{$close}{$response->code} {$statusText}\n";
    foreach ($response->headers as $header) {
        echo "{$label}[HEADER]{$close}{$header}\n";
    }
    if (is_array($response->body) || $response->body instanceof \Traversal) {
        foreach ($response->body as $key => $body) {
            $body = is_array($body) ? json_encode($body) : $body;
            echo "{$label}[BODY]{$label1}{$key}{$close}:" . $body. PHP_EOL;
        }
    } else {
        echo "{$label}[BODY]{$close}\n" . $response->body;
    }
    echo PHP_EOL;
    exit(0);
