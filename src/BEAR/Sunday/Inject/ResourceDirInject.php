<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

/**
 * Resource directory path setter
 */
trait ResourceDirInject
{
    /**
     * @var string
     */
    private $resourceDir;

    /**
     * @param string $resourceDir
     *
     * @Ray\Di\Di\Inject
     * @Ray\Di\Di\Named("resource_dir")
     */
    public function setResourceDir($resourceDir)
    {
        $this->resourceDir = $resourceDir;
    }
}
