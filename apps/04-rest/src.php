<?php
/**
 * Manual Loader
 */

// framework
require_once dirname(dirname(__DIR__)) . '/src.php';

// di modules
require_once __DIR__ . '/Module/SmartyProvider.php';
require_once __DIR__ . '/Module/TwigProvider.php';
require_once __DIR__ . '/Module/AppModule.php';
require_once __DIR__ . '/Module/SchemeCollectionProvider.php';
// app page
require_once __DIR__ . '/Page/Hello.php';
require_once __DIR__ . '/Page/HelloResource.php';
require_once __DIR__ . '/Page/app/Hello.php';
require_once __DIR__ . '/Page/aop/Log.php';
require_once __DIR__ . '/Page/template/Php.php';
require_once __DIR__ . '/Page/template/Twig.php';
require_once __DIR__ . '/Page/template/Smarty3.php';
require_once __DIR__ . '/Page/template/Haanga.php';
// code page
require_once __DIR__ . '/Page/Code.php';
require_once __DIR__ . '/Page/Code404.php';
// app resource
require_once __DIR__ . '/ResourceObject/Greeting.php';
require_once __DIR__ . '/ResourceObject/Greeting/Aop.php';
// interceptors
require_once __DIR__ . '/Interceptor/Log.php';
require_once dirname(dirname(__DIR__)) . '/vendor/Twig/lib/Twig/Environment.php';
// hello world app
require_once dirname(__DIR__) . '/00-helloworld-min/src.php';