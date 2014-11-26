<?php
/**
 * This file is part of the *** package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Provide\Application;

use BEAR\Sunday\Extension\Application\AppInterface;
use BEAR\Sunday\Module\SundayModule;
use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(AppInterface::class)->to(MinApp::class);
        $this->install(new SundayModule);
    }
}
