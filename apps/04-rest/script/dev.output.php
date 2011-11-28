<?php
/**
 * Output script.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 *
 * @input $http
 */

$code = new BEAR\Resource\Code;
$statusText =  (isset($code->statusText[$http->code])) ? $code->statusText[$http->code] : '';

if (PHP_SAPI === 'cli') {
    goto cli;
}

web:
    // code
    header("{$_ENV['SERVER_PROTOCOL']} {$http->code} {$statusText}", true, $http->code);
    // header
    foreach ($http->headers as $header) {
        header($header);
    }
    // body
    echo $http->body;
    exit(0);

cli:
    $label = "\033[1;32m";
    $close = "\033[0m";
    if (isset($appStart)) {
        $http->headers[] = 'X-Request-Per-Second: ' . (int)(1 / (microtime(true) - $appStart));
        $http->headers[] = 'X-Memory-Peak-Usage: ' . number_format(memory_get_peak_usage(true));
    }
    echo "{$label}[CODE]{$close}{$http->code} {$statusText}\n";
    foreach ($http->headers as $header) {
        echo "{$label}[HEADER]{$close}{$header}\n";
    }
    echo "{$label}[BODY]{$close}\n" . $http->body;
    echo PHP_EOL;
    exit(0);