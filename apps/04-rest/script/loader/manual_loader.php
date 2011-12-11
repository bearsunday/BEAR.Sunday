<?php
/**
 * Manual Loader
 */
require $system . '/src.php';
// di modules
require $appPath . '/Module/SmartyProvider.php';
require $appPath . '/Module/TwigProvider.php';
require $appPath . '/Module/AppModule.php';
require $appPath . '/Module/SchemeCollectionProvider.php';
// app page
require $appPath . '/Page/Hello.php';
require $appPath . '/Page/HelloResource.php';
require $appPath . '/Page/app/Hello.php';
require $appPath . '/Page/aop/Log.php';
require $appPath . '/Page/template/Php.php';
require $appPath . '/Page/template/Twig.php';
require $appPath . '/Page/template/Smarty3.php';
require $appPath . '/Page/template/Haanga.php';
// code page
require $appPath . '/Page/Code.php';
require $appPath . '/Page/Code404.php';
// app resource
require $appPath . '/ResourceObject/Greeting.php';
require $appPath . '/ResourceObject/Greeting/Aop.php';
// interceptors
require $appPath . '/Interceptor/Log.php';
require dirname($appPath) . '/00-helloworld-min/src.php';