<?php
/**
 * Loader (to be replaced to autolodaer)
 */
namespace hellowolrd\Loader;

require $system . '/src.php';
require $appPath . '/Module/FrameWorkModule.php';
require $appPath . '/Module/AppModule.php';
require $appPath . '/Module/ResourceAdapterProvider.php';
require $appPath . '/Page/Log.php';
require $appPath . '/ResourceObject/Greeting.php';
require $appPath . '/ResourceObject/Greeting/Aop.php';
require $appPath . '/Interceptor/Log.php';