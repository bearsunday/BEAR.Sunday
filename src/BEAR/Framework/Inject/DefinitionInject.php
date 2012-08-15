<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Inject;

use Aura\Di\ConfigInterface as Config;
use Ray\Di\Di\Inject;

/**
 * Inject class definition
 *
 * @package    BEAR.Framework
 * @subpackage Inject
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
