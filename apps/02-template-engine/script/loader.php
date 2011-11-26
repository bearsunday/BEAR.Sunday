<?php
/**
 * Loader (to be replaced to autolodaer)
 */
require $system . '/src.php';
require $appPath . '/Module/FrameWorkModule.php';
require $appPath . '/Module/AppModule.php';
require $appPath . '/Module/ResourceAdapterProvider.php';
require $appPath . '/Module/TwigProvider.php';
require $appPath . '/Module/SmartyProvider.php';
require $appPath . '/Page/Php.php';
require $appPath . '/Page/Smarty3.php';
require $appPath . '/Page/Twig.php';
require $appPath . '/Page/Haanga.php';
// require $appPath . '/Page/Haanga.php';
require $appPath . '/ResourceObject/Greeting.php';
require $appPath . '/ResourceObject/Greeting/Aop.php';
require $appPath . '/Interceptor/Log.php';