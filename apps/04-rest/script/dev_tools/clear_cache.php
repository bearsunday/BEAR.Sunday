<?php

// delete cacheå
$tmpFiles = glob(dirname(dirname(__DIR__)) . '/tmp/*', GLOB_NOSORT);
@array_map('unlink', $tmpFiles);