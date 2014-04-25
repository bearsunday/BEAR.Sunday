<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

/**
 * Application vendor library directory path setter
 */
trait LibDirInject
{
    /**
     * @var string
     */
    private $libDir;


    /**
     * @param string $libDir
     *
     * @Ray\Di\Di\Inject
     * @Ray\Di\Di\Named("lib_dir")
     */
    public function setLibDir($libDir)
    {
        $this->libDir = $libDir;
    }
}
