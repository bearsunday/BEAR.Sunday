<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\ResourceView;

use BEAR\Resource\RenderInterface;
use BEAR\Sunday\Extension\TemplateEngine\TemplateEngineAdapterInterface;

/**
 * Interface for console output
 *
 * @package    BEAR.Sunday
 * @subpackage Extension
 */
interface TemplateEngineRendererInterface extends RenderInterface
{
    /**
     * ViewRenderer Setter
     *
     * @param TemplateEngineAdapterInterface $templateEngineAdapter
     *
     * @Inject
     */
    public function __construct(TemplateEngineAdapterInterface $templateEngineAdapter);
}
