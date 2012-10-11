<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Web;

use BEAR\Sunday\Exception\InvalidResourceType;
use BEAR\Sunday\Inject\LogInject;
use BEAR\Sunday\Application\LoggerInterface as AppLogger;
use BEAR\Sunday\Output\ConsoleInterface;
use BEAR\Resource\Logger;
use BEAR\Resource\Object as ResourceObject;
use BEAR\Sunday\Resource\AbstractPage as Page;
use Symfony\Component\HttpFoundation\Response;
use Ray\Aop\Weave;

use Exception;

/**
 * Output with using Symfony HttpFoundation
 *
 * @package    BEAR.Sunday
 * @subpackage Web
 */
final class SymfonyResponse implements ResponseInterface
{
    use LogInject;

    /**
     * Exception
     *
     * @var Exception
     */
    private $e;

    /**
     * Resource object
     *
     * @var BResourceObject
     */
    private $resource;

    /**
     * Response resource object
     *
     * @var Response
     */
    private $response;

    private $code;
    private $headers;
    private $view;

    /**
     * @var ConsoleOutput
     */
    private $consoleOutput;

    /**
     * Set application logger
     *
     * @param \BEAR\Sunday\Application\LoggerInterface $appLogger
     *
     * @Inject
     */
    public function setAppLogger(AppLogger $appLogger)
    {
        $this->appLogger = $appLogger;
    }

    /**
     * Constructor
     *
     * @param ConsoleInterface $consoleOutput
     *
     * @Inject
     */
    public function __construct(ConsoleInterface $consoleOutput)
    {
        $this->consoleOutput = $consoleOutput;
    }

    /**
     * Set Resource
     *
     * @param mixed $resource BEAR\Resource\Object | Ray\Aop\Weaver $resource
     *
     * @throws InvalidResourceType
     * @return \BEAR\Sunday\Web\SymfonyResponse
     */
    public function setResource($resource)
    {
        if ($resource instanceof Weave) {
            $resource = $resource->___getObject();
        }
        if ($resource instanceof ResourceObject === false && $resource instanceof Weave === false) {
            $type = (is_object($resource)) ? get_class($resource) : gettype($resource);
            throw new InvalidResourceType($type);
        }
        $this->resource = $resource;

        return $this;
    }

    /**
     * Set Exception
     *
     * @param \Exception $e
     * @param int        $exceptionId
     *
     * @return SymfonyResponse
     */
    public function setException(Exception $e, $exceptionId)
    {
        $this->e = $e;
        $this->code = $e->getCode();
        $this->headers = [];
        $this->body = $exceptionId;

        return $this;
    }

    /**
     * Render
     *
     * @param Callable $renderer
     *
     * @return self
     */
    public function render(Callable $renderer = null)
    {
        if (is_callable($renderer)) {
            $this->view = $renderer($this->body);
        } else {
            $this->view = (string)$this->resource;
        }

        return $this;
    }

    /**
     * Make responce object with RFC 2616 compliant HTTP header
     *
     * @return \BEAR\Sunday\Web\SymfonyResponse
     */
    public function prepare()
    {
        $this->response = new Response($this->view, $this->resource->code, (array)$this->resource->headers);
        // compliant with RFC 2616.
        $this->response->prepare();

        return $this;
    }

    /**
     * Output web console log (FireBug + FirePHP)
     *
     * @return \BEAR\Sunday\Web\SymfonyResponse
     */
    public function outputWebConsoleLog()
    {
        $this->appLogger->outputWebConsoleLog();

        return $this;
    }

    /**
     * Transfer representational state to http client (or console output)
     *
     * @return \BEAR\Sunday\Web\SymfonyResponse
     */
    public function send()
    {
        if (PHP_SAPI === 'cli') {
            if ($this->resource instanceof Page) {
                $this->resource->headers = $this->response->headers->all();
            }
            $statusText = Response::$statusTexts[$this->resource->code];
            $this->consoleOutput->send($this->resource, $this->e, $statusText);
        } else {
            $this->response->send();
        }

        return $this;
    }
}
