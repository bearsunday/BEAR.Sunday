<?php

namespace BEAR\Framework\Utility;

/**
 * Delete a file or recursively delete a directory
 *
 * @param string $str Path to file or directory
 */
$recursiveDelete = function ($str) use (&$recursiveDelete){
    if(is_file($str)){
        return @unlink($str);
    }
    elseif(is_dir($str)){
        $scan = glob(rtrim($str,'/').'/*');
        foreach($scan as $index=>$path){
            $recursiveDelete($path);
        }
        return @rmdir($str);
    }
};
$recursiveDelete(dirname(dirname(__DIR__)) . '/tmp');
unset($recursiveDelete);

if (function_exists('apc_clear_cache')) {
    apc_clear_cache();
    apc_clear_cache('user');
    apc_clear_cache('opcode');
}

clearstatcache();
