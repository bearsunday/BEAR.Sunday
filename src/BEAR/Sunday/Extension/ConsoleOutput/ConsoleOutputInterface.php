<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\ConsoleOutput;

use BEAR\Sunday\Extension\ExtensionInterface;

/**
 * Interface for console output
 *
 * @package    BEAR.Sunday
 * @subpackage Extension
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
