<?php
/**
 * Output script.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */

if (PHP_SAPI === 'cli') {
    goto cli;
}

web:
    foreach ($http->headers as $header) {
        header($header);
    }
    echo $http->body;
    exit(0);

cli:
    $label = "\033[1;32m";
    $close = "\033[0m";
    $http->headers[] = 'X-Request-Per-Second: ' . (int)(1 / (microtime(true) - $start));
    $http->headers[] = 'X-Memory-Peak-Usage: ' . number_format(memory_get_peak_usage(true));
    foreach ($http->headers as $header) {
        echo "{$label}[HEADER]{$close}{$header}\n";
    }
    echo "{$label}[BODY]{$close}\n" . $http->body;
    exit(0);