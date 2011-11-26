<?php
/**
 * App boot
 *
 * Required to set: $appName, $appPath
 *
 * @packate BEAR.template
 *
 */
namespace template;


include __DIR__ . '/bootstrap.php';

// delete cache
$tmpFiles = glob($appPath . '/tmp/resource/%%RES%%*');
array_map('unlink', $tmpFiles);

