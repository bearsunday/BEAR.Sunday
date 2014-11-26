<?php
/**
 * This file is part of the *** package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Provide\Transfer;

use Ray\Di\AbstractModule;
use BEAR\Sunday\Extension\Transfer\TransferInterface;

class HttpResponderModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(TransferInterface::class)->to(HttpResponder::class);
    }
}
