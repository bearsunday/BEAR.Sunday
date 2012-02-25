<?php
register_shutdown_function(function () {
    $includeFiles = get_included_files();
    $require = '';
    foreach ($includeFiles as $file) {
        if (strpos($file, '/tmp/') === false) {
            $require .= "require '$file';\n";
        }
    }
   echo $require;
});

