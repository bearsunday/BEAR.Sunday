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
trait VendorDirInject
{
    /**
     * App vendor path
     *
     * @var string
     */
    private $vendorDir;


    /**
     * App directory path setter
     *
     * @param string $vendorDir
     *
     * @return void
     *
     * @Ray\Di\Di\Inject
     * @Ray\Di\Di\Named("vendor_dir")
     */
    public function setVendorDir($vendorDir)
    {
        $this->vendorDir = $vendorDir;
    }
}
