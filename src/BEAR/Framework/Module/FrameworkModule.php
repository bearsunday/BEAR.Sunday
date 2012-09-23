<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module;

use Ray\Di\Injector;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Application module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class FrameworkModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        // install
        $this->install(new Log\MonologModule);
        $injector = Injector::create([$this]);
        $monologLogger = $injector->getInstance('BEAR\Framework\Module\Log\MonologModule\MonologProvider')->get();
        $logger = $this->requestInjection('BEAR\Framework\Inject\Logger\Adapter');
        $injector->setLogger($logger);
        $config = $injector->getContainer()->getForge()->getConfig();
        $this->bind('')->annotatedWith('is_prod')->toInstance(false);
        $this->bind('Aura\Di\ConfigInterface')->toInstance($config);
        $this->bind('Ray\Di\InjectorInterface')->toInstance($injector);
        $this->bind('BEAR\Resource\ResourceInterface')->to('BEAR\Resource\Resource')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\InvokerInterface')->to('BEAR\Resource\Invoker')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\LinkerInterface')->to('BEAR\Resource\Linker')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\LoggerInterface')->annotatedWith("resource_logger")->to('BEAR\Resource\Logger');
        $this->bind('BEAR\Resource\LoggerInterface')->toProvider('BEAR\Framework\Module\Provider\ResourceLoggerProvider');
        $this->bind('Guzzle\Common\Cache\AbstractCacheAdapter')->toProvider('BEAR\Framework\Module\Provider\ApcCacheProvider')->in(Scope::SINGLETON);
        $this->bind('Aura\Signal\Manager')->toProvider('BEAR\Framework\Module\Provider\SignalProvider')->in(Scope::SINGLETON);
        $this->bind('BEAR\Framework\Web\ResponseInterface')->to('BEAR\Framework\Web\SymfonyResponse');
        $this->bind('BEAR\Framework\Exception\ExceptionHandlerInterface')->to('BEAR\Framework\Exception\ExceptionHandler');
        $this->bind('BEAR\Framework\Output\ConsoleInterface')->to('BEAR\Framework\Output\Console');
        $this->bind('Doctrine\Common\Annotations\Reader')->to('Doctrine\Common\Annotations\AnnotationReader');
        $this->bind('BEAR\Framework\Resource\CacheControl\Taggable')->to('BEAR\Framework\Resource\CacheControl\Etag');
        $this->bind('BEAR\Resource\Referable')->to('BEAR\Resource\A');
        $this->bind('Guzzle\Parser\UriTemplate\UriTemplateInterface')->to('Guzzle\Parser\UriTemplate\UriTemplate');
    }
}
