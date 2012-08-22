<?php
/**
 * BEAR.Sunday install checker
 *
 * usage
 *
 * $ php path/to/check.php;
 *
 * @author Akihito Koriyama <akihito.koriyama@gmail.com>
 */
$id = isset($_ENV['BEAR_DB_ID']) ? $_ENV['BEAR_DB_ID'] : 'root';
$password = isset($_ENV['BEAR_DB_PASSWORD']) ? $_ENV['BEAR_DB_PASSWORD'] : '';
$phpVersion = phpversion();
$apcVersion = phpversion("apc");

$vendorInstalled = file_exists(dirname(__DIR__) . '/vendor/composer/installed.json') ? 'OK' : 'NG';

echo "PHP: " . $phpVersion . PHP_EOL;
echo "APC: " . $apcVersion . PHP_EOL;
echo 'apc.enable_cli:' . ini_get('apc.enable_cli') . PHP_EOL;
echo 'DB ID/PASS:' . "{$id}/{$password}" . PHP_EOL;
echo 'variables_order: ' . ini_get('variables_order') . PHP_EOL;
if (phpversion("xhprof")) {
    echo 'xhprof.output_dir:' . ini_get('xhprof.output_dir') . PHP_EOL;
}

try {
    $pdo = new \PDO("mysql:host=localhost; dbname=blogbeartest", $id, $password);
    $dbConnection = 'OK';
} catch (Exception $e) {
    $dbConnection = $e->getMessage();
}
echo "DB connect:{$dbConnection}" . PHP_EOL;
echo "vendor installed: {$vendorInstalled}" . PHP_EOL;

echo "(option) xhprof: " . phpversion("xhprof") . PHP_EOL;
if (phpversion("xhprof")) {
    echo '(option) xhprof.output_dir:' . ini_get('xhprof.output_dir') . PHP_EOL;
}

$isInstallOk = (version_compare($phpVersion, '5.4', '>=')
            && (version_compare($apcVersion, '3.1.8', '>='))
            && ($vendorInstalled === 'OK')
            && ($dbConnection === 'OK'));
$insall = $isInstallOk ? 'OK' : 'NG';

echo PHP_EOL;
echo "BEAR.Sunday INSTALL: {$insall}" . PHP_EOL;
return $isInstallOk;