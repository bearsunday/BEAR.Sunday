<?php
/**
 * Core file loader
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 * @globals $system system path
 */
namespace BEAR\Framework\Scripts;

use BEAR\Framework\Framework;

$system = Framework::$systemRoot;

$er = error_reporting();
error_reporting(0);
include $system . '/vendor/doctrine/common/lib/Doctrine/Common/Annotations/AnnotationRegistry.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/InjectorInterface.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/Injector.php';
include $system . '/vendor/Aura/Di/src/Aura/Di/ConfigInterface.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/Config.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/ApcConfig.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/Definition.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/Scope.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/Di/Annotation.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/Di/Inject.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/Di/Named.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/AnnotationInterface.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/Annotation.php';
include $system . '/vendor/doctrine/common/lib/Doctrine/Common/Annotations/DocParser.php';
include $system . '/vendor/doctrine/common/lib/Doctrine/Common/Lexer.php';
include $system . '/vendor/doctrine/common/lib/Doctrine/Common/Annotations/DocLexer.php';
include $system . '/vendor/doctrine/common/lib/Doctrine/Common/Annotations/Annotation/Target.php';
include $system . '/vendor/doctrine/common/lib/Doctrine/Common/Annotations/PhpParser.php';
include $system . '/vendor/Aura/Di/src/Aura/Di/ContainerInterface.php';
include $system . '/vendor/Aura/Di/src/Aura/Di/Container.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/Container.php';
include $system . '/vendor/Aura/Di/src/Aura/Di/ForgeInterface.php';
include $system . '/vendor/Aura/Di/src/Aura/Di/Forge.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/Forge.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/AbstractModule.php';
include $system . '/vendor/guzzle/guzzle/src/Guzzle/Common/Cache/CacheAdapterInterface.php';
include $system . '/vendor/guzzle/guzzle/src/Guzzle/Common/Cache/AbstractCacheAdapter.php';
include $system . '/vendor/guzzle/guzzle/src/Guzzle/Common/Cache/DoctrineCacheAdapter.php';
include $system . '/vendor/doctrine/common/lib/Doctrine/Common/Cache/Cache.php';
include $system . '/vendor/doctrine/common/lib/Doctrine/Common/Cache/CacheProvider.php';
include $system . '/vendor/doctrine/common/lib/Doctrine/Common/Cache/ApcCache.php';
include $system . '/vendor/Ray/Aop/src/Ray/Aop/Pointcut.php';
include $system . '/vendor/Ray/Aop/src/Ray/Aop/Matchable.php';
include $system . '/vendor/Ray/Aop/src/Ray/Aop/Matcher.php';
include $system . '/vendor/doctrine/common/lib/Doctrine/Common/Annotations/Reader.php';
include $system . '/vendor/doctrine/common/lib/Doctrine/Common/Annotations/AnnotationReader.php';
include $system . '/vendor/Ray/Aop/src/Ray/Aop/Advice.php';
include $system . '/vendor/Ray/Aop/src/Ray/Aop/Interceptor.php';
include $system . '/vendor/Ray/Aop/src/Ray/Aop/MethodInterceptor.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Interceptor/DbInjector.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Interceptor/CacheInterface.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Interceptor/CacheLoader.php';
include $system . '/apps/sandbox/Interceptor/Checker.php';
include $system . '/apps/sandbox/Interceptor/PostFormValidater.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Interceptor/TimeStamper.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Interceptor/Transactional.php';
include $system . '/apps/sandbox/Interceptor/TimeMessage.php';
include $system . '/vendor/Ray/Di/src/Ray/Di/LoggerInterface.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Inject/LogInject.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Inject/Logger/Adapter.php';
include $system . '/vendor/guzzle/guzzle/src/Guzzle/Common/Log/LogAdapterInterface.php';
include $system . '/vendor/guzzle/guzzle/src/Guzzle/Common/Log/AbstractLogAdapter.php';
include $system . '/vendor/guzzle/guzzle/src/Guzzle/Common/Log/MonologLogAdapter.php';
include $system . '/vendor/monolog/monolog/src/Monolog/Logger.php';
include $system . '/vendor/monolog/monolog/src/Monolog/Handler/HandlerInterface.php';
include $system . '/vendor/monolog/monolog/src/Monolog/Handler/AbstractHandler.php';
include $system . '/vendor/monolog/monolog/src/Monolog/Handler/AbstractProcessingHandler.php';
include $system . '/vendor/monolog/monolog/src/Monolog/Handler/StreamHandler.php';
include $system . '/vendor/Ray/Aop/src/Ray/Aop/Bind.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/ResourceInterface.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/Resource.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/FactoryInterface.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/Factory.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/SchemeCollection.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/Object.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/Provider.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/Adapter/Adapter.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/Adapter/App.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/InvokerInterface.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/Invoker.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/LinkerInterface.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/Linker.php';
include $system . '/vendor/Aura/Signal/src/Aura/Signal/Manager.php';
include $system . '/vendor/Aura/Signal/src/Aura/Signal/HandlerFactory.php';
include $system . '/vendor/Aura/Signal/src/Aura/Signal/Handler.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/SignalHandler/Handle.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/SignalHandler/Provides.php';
include $system . '/vendor/Aura/Signal/src/Aura/Signal/ResultCollection.php';
include $system . '/vendor/Aura/Signal/src/Aura/Signal/ResultFactory.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/Requestable.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/Request.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Web/ResponseInterface.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Web/SymfonyResponse.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Exception/ExceptionHandlerInterface.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Inject/LogDirInject.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Exception/ExceptionHandler.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Router/Router.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/BodyArrayAccess.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/AbstractObject.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Resource/AbstractPage.php';
include $system . '/vendor/BEAR/Resource/src/BEAR/Resource/Renderable.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Resource/View/Renderer.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Resource/View/TemplateEngineAdapter.php';
include $system . '/package/BEAR/Framework/src/BEAR/Framework/Module/TemplateEngine/SmartyModule/SmartyAdapter.php';
include $system . '/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/Response.php';
include $system . '/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/HeaderBag.php';
include $system . '/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/ResponseHeaderBag.php';

error_reporting($er);
