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

$system = dirname(dirname(dirname(__DIR__)));
require $system . '/vendor/Aura.Autoload/src/Aura/Autoload/Loader.php';
require $system . '/vendor/Aura.Autoload/src/Aura/Autoload/Exception.php';
require $system . '/vendor/Aura.Autoload/src/Aura/Autoload/Exception/AlreadyLoaded.php';
require $system . '/vendor/Aura.Autoload/src/Aura/Autoload/Exception/NotReadable.php';
require $system . '/vendor/Aura.Autoload/src/Aura/Autoload/Exception/NotDeclared.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Annotations/AnnotationRegistry.php';
require $system . '/vendor/Aura.Router/src/Aura/Router/Map.php';
require $system . '/vendor/Aura.Router/src/Aura/Router/RouteFactory.php';
require $system . '/package/BEAR.Framework/src/BEAR/Framework/StandardRouter.php';
require $system . '/package/BEAR.Framework/src/BEAR/Framework/Globals.php';
require $system . '/vendor/Aura.Router/src/Aura/Router/Route.php';
require $system . '/vendor/Guzzle/src/Guzzle/Common/Cache/CacheAdapterInterface.php';
require $system . '/vendor/Guzzle/src/Guzzle/Common/Cache/AbstractCacheAdapter.php';
require $system . '/vendor/Guzzle/src/Guzzle/Common/Cache/DoctrineCacheAdapter.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Cache/Cache.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Cache/CacheProvider.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Cache/ApcCache.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/InjectorInterface.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Injector.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/ContainerInterface.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Container.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/ForgeInterface.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Forge.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/ConfigInterface.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Config.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/AnnotationInterface.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Annotation.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Definition.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Scope.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Lexer.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Annotations/DocParser.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Annotations/DocLexer.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Annotations/Annotation/Target.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Annotations/PhpParser.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/AbstractModule.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/EmptyModule.php';
require $system . '/vendor/Ray.Aop/src/Ray/Aop/Bind.php';
require $system . '/package/BEAR.Framework/src/BEAR/Framework/Module/StandardModule.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Resource.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Client.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Invokable.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Invoker.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Linkable.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Linker.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/ProviderInterface.php';
require $system . '/package/BEAR.Framework/src/BEAR/Framework/Module/Provider/CacheProvider.php';
require $system . '/package/BEAR.Framework/src/BEAR/Framework/Module/Provider/SignalProvider.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Annotations/Reader.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Annotations/AnnotationReader.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Annotations/Annotation/IgnoreAnnotation.php';
require $system . '/vendor/Ray.Aop/src/Ray/Aop/Matcher.php';
require $system . '/package/BEAR.Framework/src/BEAR/Framework/Module/AbstractSingletonProvider.php';
require $system . '/vendor/Ray.Aop/src/Ray/Aop/Advice.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Di/Annotation.php';
require $system . '/vendor/Ray.Aop/src/Ray/Aop/Interceptor.php';
require $system . '/vendor/Ray.Aop/src/Ray/Aop/MethodInterceptor.php';
require $system . '/vendor/Ray.Aop/src/Ray/Aop/Pointcut.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Di/Scope.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Annotations/Annotation/Attribute.php';
require $system . '/vendor/Doctrine.Common/lib/Doctrine/Common/Annotations/Annotation/Attributes.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Di/Inject.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/ResourceFactory.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Factory.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Request.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/ArrayAccess.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/SchemeCollection.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Di/Named.php';
require $system . '/vendor/Ray.Di/src/Ray/Di/Di/ImplementedBy.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Object.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Provider.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Adapter/App.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Adapter/Http.php';
require $system . '/vendor/Aura.Signal/src/Aura/Signal/Manager.php';
require $system . '/vendor/Aura.Signal/src/Aura/Signal/HandlerFactory.php';
require $system . '/vendor/Aura.Signal/src/Aura/Signal/ResultFactory.php';
require $system . '/vendor/Aura.Signal/src/Aura/Signal/ResultCollection.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/SignalHandler/Handle.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/SignalHandler/Provides.php';
require $system . '/vendor/Aura.Signal/src/Aura/Signal/Handler.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/AbstractObject.php';
require $system . '/package/BEAR.Framework/src/BEAR/Framework/Link/View/Php.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Adapter/App/Link.php';
require $system . '/vendor/BEAR.Resource/src/BEAR/Resource/Code.php';
