<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\ConsoleOutput;

use BEAR\Sunday\Extension\ExtensionInterface;

/**
 * Interface for console output
 */
interface ConsoleOutputInterface extends ExtensionInterface
{
    /**
     * Disable output
     *
     * @return self
     */
    public function disableOutput();

    /**
     * Send CLI output
     *
     * @param ResourceObject $resource
     * @param string         $statusText
     *
     * @return string
     */
    public function send(ResourceObject $resource, $statusText = '');
}
