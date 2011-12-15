<?php
/**
 * Manual Loader
 */
use \Symfony\Component\ClassLoader\UniversalClassLoader as ClassLoader;

$system = dirname(dirname(__DIR__));
// framework
require_once $system . '/src.php';
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
require_once __DIR__ . '/Page/http/GoogleNews.php';
require_once __DIR__ . '/Page/http/Multi.php';
require_once __DIR__ . '/Page/hyperlink/restbucks.php';
require_once __DIR__ . '/Page/hyperlink/order.php';
// code page
require_once __DIR__ . '/Page/Code.php';
require_once __DIR__ . '/Page/Code404.php';
// app resource
require_once __DIR__ . '/ResourceObject/Greeting.php';
require_once __DIR__ . '/ResourceObject/Greeting/Aop.php';
require_once __DIR__ . '/ResourceObject/RestBucks/Menu.php';
require_once __DIR__ . '/ResourceObject/RestBucks/Order.php';
require_once __DIR__ . '/ResourceObject/RestBucks/Payment.php';
// interceptors
require_once __DIR__ . '/Interceptor/Log.php';
require_once $system . '/vendor/Twig/lib/Twig/Environment.php';
// hello world app
require_once dirname(__DIR__) . '/00-helloworld-min/src.php';

require_once $system  . '/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$classLoader = new ClassLoader;
$classLoader->registerNamespaces(array(
            'Guzzle' => $system  . '/vendor/Guzzle/src',
            'Doctrine' => $system  . '/vendor/Doctrine/lib',
            'Monolog' => $system  . '/vendor/Monolog/src'
));
$classLoader->registerPrefix('Zend_', $system . '/vendor');
$classLoader->register();
unset($system);