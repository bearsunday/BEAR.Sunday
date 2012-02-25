<?php
/**
 * BEAR.Framework src
 */

// Framework libs
require __DIR__ . '/src/BEAR/Framework/Module/StandardModule.php';
require __DIR__ . '/src/BEAR/Framework/DevRouter.php';
require __DIR__ . '/src/BEAR/Framework/Dispatcher.php';
// View trait
require __DIR__ . '/src/BEAR/Framework/Link/View/Php.php';
require __DIR__ . '/src/BEAR/Framework/Link/View/Smarty3.php';
require __DIR__ . '/src/BEAR/Framework/Link/View/Twig.php';
require __DIR__ . '/src/BEAR/Framework/Link/View/Haanga.php';

require __DIR__ . '/src/BEAR/Framework/Module/Singleton.php';
require __DIR__ . '/src/BEAR/Framework/Module/AbstractSingletonProvider.php';
require __DIR__ . '/src/BEAR/Framework/Module/AbstractPrototypeProvider.php';
require __DIR__ . '/src/BEAR/Framework/Interceptor/Transactional.php';
require __DIR__ . '/src/BEAR/Framework/Interceptor/Cache.php';
// require __DIR__ . '/src/BEAR/Framework/Interceptor/CacheUpdate.php';
// Exceptions
require __DIR__ . '/src/BEAR/Framework/Exception/NotFound.php';
// vendor
