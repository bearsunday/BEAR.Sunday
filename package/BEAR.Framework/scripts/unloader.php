<?php
/**
 * "Unloader"
 *
 * Prints all include file to help create manula loader script.
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Scripts;

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

