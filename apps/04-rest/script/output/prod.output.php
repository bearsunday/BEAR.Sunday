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
    echo "{$response->code} {$statusText}" ."\n";
    foreach ($response->headers as $header) {
        echo "{$header}\n";
    }
    echo "\n" . $response->body;
    echo PHP_EOL;
    exit(0);