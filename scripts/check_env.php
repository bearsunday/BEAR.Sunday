<?php
/**
 * BEAR.Sunday install checker
 *
 * usage:
 *
 * $ php path/to/check.php;
 *
 * @author Akihito Koriyama <akihito.koriyama@gmail.com>
 */

$ok = "\e[07;32m" . ' OK ' . "\033[0m";
$ng = "\e[07;31m" . ' NG ' . "\033[0m";

// PHP
$isPhpVersionOk = version_compare(phpversion(), '5.4', '>=') ? $ok : $ng;
echo "{$isPhpVersionOk}PHP:" . phpversion() . PHP_EOL;

// APC
$apcVersion = phpversion("apc");
$isAPCVersionOk = version_compare(phpversion("apc"), '3.1.8', '>=') ? $ok : $ng;
echo "{$isAPCVersionOk}APC:" . phpversion("apc") . PHP_EOL;
$apcEnableCli =  ini_get('apc.enable_cli') ? $ok : $ng;
echo "{$apcEnableCli}apc.enable_cli" . PHP_EOL;

// DB
$id = isset($_ENV['BEAR_DB_ID']) ? $_ENV['BEAR_DB_ID'] : 'root';
$password = isset($_ENV['BEAR_DB_PASSWORD']) ? $_ENV['BEAR_DB_PASSWORD'] : '';
try {
    $pdo = new \PDO("mysql:host=localhost; dbname=blogbeartest", $id, $password);
    $isDbConnectionOk = $ok;
} catch (Exception $e) {
    $isDbConnectionOk = $e->getMessage();
}
echo "{$isDbConnectionOk}DB connect({$id}/{$password})" . PHP_EOL;

// vendor
$isVendorInstalledOk = file_exists(dirname(__DIR__) . '/vendor/composer/installed.json') ? $ok : $ng;

echo "{$isVendorInstalledOk}Vendor install" . PHP_EOL;
// options
echo "(option) xhprof: " . phpversion("xhprof") . '(' . ini_get('xhprof.output_dir') . ')' . PHP_EOL;
if (phpversion("xhprof")) {
    echo '(option) xhprof.output_dir:' . ini_get('xhprof.output_dir') . PHP_EOL;
}

// info
echo '(info) variables_order: ' . ini_get('variables_order') . PHP_EOL;
echo '(info) php.ini: ' . ini_get('variables_order') . PHP_EOL;

$isEnvOk = ($isPhpVersionOk === $ok
            && ($isAPCVersionOk === $ok)
            && ($isVendorInstalledOk === $ok)
            && ($isDbConnectionOk === $ok));
$isInsallOk = $isEnvOk ? $ok : $ng;

echo PHP_EOL;
echo "BEAR.Sunday INSTALL: {$isInsallOk}" . PHP_EOL;
return $isEnvOk;
