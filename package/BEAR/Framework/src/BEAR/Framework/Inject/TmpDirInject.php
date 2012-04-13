<?php
/**
 * BEAR.Framework
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

/**
 * Inject tmp_dir
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
trait TmpDirInject
{
    /**
     * Tmp dir
     *
     * @var Log
     */
    private $tmpDir;

    /**
     * Constructor
     *
     * @param string $tmp
     *
     * @Inject
     * @Named("tmp_dir")
     */
    public function __construct($tmpDir)
    {
        $this->tmpDir = $tmpDir;
    }
}
