<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

/**
 * Inject application vendor directory path
 */
trait LibDirInject
{
    /**
     * App vendor path
     *
     * @var string
     */
    private $libDir;


    /**
     * App directory path setter
     *
     * @param string $libDir
     *
     * @return void
     *
     * @Ray\Di\Di\Inject
     * @Ray\Di\Di\Named("lib_dir")
     */
    public function setLibDir($libDir)
    {
        $this->libDir = $libDir;
    }
}
