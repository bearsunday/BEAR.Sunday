<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Aura\Di\ConfigInterface;
use Ray\Di\Config;
use Ray\Di\Di\Inject;

/**
 * Inject class definition
 *
 * @package    BEAR.Sunday
 * @subpackage Inject
 */
trait DefinitionInject
{

    /**
     * Set definition
     *
     * @param ConfigInterface $config
     *
     * @Inject
     */
    public function setDefinition(ConfigInterface $config)
    {
        $this->definition = $config->fetch(get_called_class())[Config::INDEX_DEFINITION];
    }
}
