<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */

spl_autoload_register(
    function ($class) {
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        $src = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $file;
        if (file_exists($src)) {
            /** @noinspection PhpIncludeInspection */
            include $src;
        }
    }
);
