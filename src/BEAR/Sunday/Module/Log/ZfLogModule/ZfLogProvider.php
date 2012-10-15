<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Log\ZfLogModule;

use BEAR\Sunday\Inject\LogDirInject;
use Guzzle\Common\Log\Zf2LogAdapter;
use Ray\Di\ProviderInterface as Provide;
use Ray\Di\Di\Inject;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

/**
 * Zend log provider
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class ZfLogProvider implements Provide
{
    use LogDirInject;

    /**
     * Provide instance
     *
     * @return CacheAdapter
     */
    public function get()
    {
        $logger = new Logger;
        $writer = new Stream($this->logDir . '/app.log');
        $logger->addWriter($writer);

        return new Zf2LogAdapter($logger);
    }
}
