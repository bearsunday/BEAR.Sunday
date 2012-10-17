<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Provider;

use BEAR\Sunday\Inject\TmpDirInject;
use BEAR\Sunday\Module\AbstractSingletonProvider;
use BEAR\Sunday\Inject\TmpDir;
use PDO;

/**
 * PDO provider
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class PdoProvider extends AbstractSingletonProvider
{
    use TmpDirInject;

    /**
     * Return instance
     *
     * @return PDO
     */
    public function newInstance()
    {
        $dbFile = $this->tmpDir . 'demo01.sqlite3';
        $instance = new PDO('sqlite:' . $dbFile, null, null);
        $instance->query("CREATE TABLE User (Id INTEGER PRIMARY KEY, Name TEXT, Age INTEGER)");

        return $instance;
    }
}
