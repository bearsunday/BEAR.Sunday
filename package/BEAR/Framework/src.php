<?php
spl_autoload_register(function($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    $src = __DIR__ . DIRECTORY_SEPARATOR . 'src'. DIRECTORY_SEPARATOR . $file;
    if (file_exists($src)) {
        require $src;
    }
});