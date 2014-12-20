<?php
$config = Symfony\CS\Config\Config::create();
$config->level(null);
$config->fixers(
    array(
        'indentation',
        'linefeed',
        'trailing_spaces',
        'short_tag',
        'visibility',
        'php_closing_tag',
        'function_declaration',
        'psr0',
        'elseif',
        'eof_ending',
        'unused_use',
    )
);
return $config;
