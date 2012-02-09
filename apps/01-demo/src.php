<?php
/**
 * Manual Loader
 */
// BEAR.Sunday/src
require_once dirname(dirname(__DIR__)) . '/src.php';
// di modules
require __DIR__ . '/Module/AppModule.php';
require __DIR__ . '/Module/Provider/SmartyProvider.php';
require __DIR__ . '/Module/Provider/TwigProvider.php';
require __DIR__ . '/Module/Provider/SchemeCollectionProvider.php';
require __DIR__ . '/Module/Provider/PdoProvider.php';
require __DIR__ . '/Module/Provider/DbalProvider.php';
// app page
require __DIR__ . '/Page/Hello.php';
require __DIR__ . '/Page/HelloResource.php';
require __DIR__ . '/Page/app/Hello.php';
require __DIR__ . '/Page/aop/Log.php';
require __DIR__ . '/Page/template/Php.php';
require __DIR__ . '/Page/template/Twig.php';
require __DIR__ . '/Page/template/Smarty3.php';
require __DIR__ . '/Page/template/Haanga.php';
require __DIR__ . '/Page/http/GoogleNews.php';
require __DIR__ . '/Page/http/Multi.php';
require __DIR__ . '/Page/hyperlink/restbucks.php';
require __DIR__ . '/Page/hyperlink/order.php';
require __DIR__ . '/Page/db/user/pdo.php';
require __DIR__ . '/Page/cache/page.php';
// code page
require __DIR__ . '/Page/Code.php';
require __DIR__ . '/Page/Code404.php';
// app resource
require __DIR__ . '/ResourceObject/Greeting.php';
require __DIR__ . '/ResourceObject/Greeting/Aop.php';
require __DIR__ . '/ResourceObject/RestBucks/Menu.php';
require __DIR__ . '/ResourceObject/RestBucks/Order.php';
require __DIR__ . '/ResourceObject/RestBucks/Payment.php';
require __DIR__ . '/ResourceObject/User/Pdo.php';
require __DIR__ . '/ResourceObject/User/Dbal.php';
// interceptors
require __DIR__ . '/Interceptor/Log.php';
// annotations
require __DIR__ . '/Annotation/Cache.php';
require __DIR__ . '/Annotation/CacheUpdate.php';
require __DIR__ . '/Annotation/Log.php';

// hello world app
require dirname(__DIR__) . '/00-helloworld-min/src.php';