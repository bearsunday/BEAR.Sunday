<?php
/**
 * BEAR.Framework src
 */

// Framework libs
require __DIR__ . '/src/Module/StandardModule.php';
require __DIR__ . '/src/DevRouter.php';
require __DIR__ . '/src/Dispatcher.php';
// View trait
require __DIR__ . '/src/Link/View/Php.php';
require __DIR__ . '/src/Link/View/Smarty3.php';
require __DIR__ . '/src/Link/View/Twig.php';
require __DIR__ . '/src/Link/View/Haanga.php';

require __DIR__ . '/src/Module/Singleton.php';
require __DIR__ . '/src/Module/AbstractSingletonProvider.php';
require __DIR__ . '/src/Module/AbstractPrototypeProvider.php';
require __DIR__ . '/src/Interceptor/Transactional.php';
require __DIR__ . '/src/Interceptor/Cacheable.php';
// Exceptions
require __DIR__ . '/src/Exception/NotFound.php';
// vendor
