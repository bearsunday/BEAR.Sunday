<?php
if (class_exists('\Aura\Autoload\Loader', false) === true) {
    return;
}
$system =
include __DIR__ . '/core_loader.php';
require $this->system . '/vendor/.composer/autoload.php';
$loader = require  $this->system . '/vendor/Aura/Autoload/scripts/instance.php';
$namespaces = require  $this->system . '/vendor' . DIRECTORY_SEPARATOR . '.composer/autoload_namespaces.php';
$namespaces += [
$this->app->name  => dirname($this->app->path),
'BEAR\Framework' => $this->system . '/package/BEAR/Framework/src/'
];
$loader->setPaths($namespaces);
$loader->register();
// silent auto loader for annotation
AnnotationRegistry::registerAutoloadNamespace('Ray\Di\Di', $this->system . '/vendor/Ray/Di/src');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Resource\Annotation', $this->system . '/vendor/BEAR/Resource/src');
AnnotationRegistry::registerAutoloadNamespace('BEAR\Framework\Annotation', $this->system . '/package/BEAR/Framework/src');
AnnotationRegistry::registerAutoloadNamespace($this->app->name . '\Annotation', dirname($this->app->path));
