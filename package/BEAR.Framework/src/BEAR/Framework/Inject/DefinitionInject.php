<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use Ray\Di\ConfigInterface as Config;

/**
 * Inject class definition
 */
trait DefinitionInject
{
    /**
     * Definition
     *
     * @var \Ray\Di\Definition
     */
    private $definition;

    /**
     * @Inject
     */
    public function setDefinition(Config $config)
    {
        $this->definition = $config->fetch(get_called_class())[2];
    }

}