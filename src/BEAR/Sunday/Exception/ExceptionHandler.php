<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package    BEAR.Sunday
 * @subpackage Exception
 * @license    http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Exception;

use BEAR\Resource\Exception\BadRequest;
use Ray\Di\InjectorInterface;
use Ray\Di\AbstractModule;
use BEAR\Resource\AbstractObject as ResourceObject;
use BEAR\Resource\Exception\MethodNotAllowed;
use BEAR\Resource\Exception\Parameter;
use BEAR\Resource\Exception\Scheme;
use BEAR\Resource\Exception\Uri;
use BEAR\Sunday\Resource\Page\Error;
use BEAR\Sunday\Web\ResponseInterface;
use BEAR\Sunday\Inject\LogDirInject;
use Exception;
use Ray\Di\Exception\Binding;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Exception handler for development
 *
 * @package    BEAR.Sunday
 * @subpackage Exception
 */
final class ExceptionHandler implements ExceptionHandlerInterface
{
    use LogDirInject;

    /**
     * Response
     *
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var Error
     */
    private $errorPage;

    /**
     * @var InjectorInterface
     */
    private $injector;

    /**
     * @var string
     */
    private $viewTemplate;

    /**
     * Error message
     *
     * @var array
     */
    private $message = [
        'ResourceNotFound' => 'The requested URI was not found on this service.',
        'BadRequest' => 'You sent a request that this service could not understand.',
        'Parameter' => 'You sent a request that query is not valid.',
        'Scheme' => 'You sent a request that scheme is not valid.',
        'MethodNotAllowed' => 'The requested method is not allowed for this URI.'
    ];

    /**
     * Set message
     *
     * @param array $message
     *
     * @Inject(optional = true);
     */
    public function setMessage(array $message)
    {
        $this->message = $message;
    }

    /**
     * Set Injector for logging
     *
     * @param array $message
     *
     * @Inject(optional = true);
     */
    public function setModule(InjectorInterface $injector)
    {
        $this->injector = $injector;
    }

    /**
     * Set response
     *
     * @param ResponseInterface $response
     *
     * @Inject
     * @Named("exceptionTpl=exceptionTpl,errorPage=errorPage")
     */
    public function __construct(
        ResponseInterface $response,
        $exceptionTpl = null,
        ResourceObject $errorPage = null
    ){
        $this->response = $response;
        $this->viewTemplate = $exceptionTpl;
        $this->errorPage = $errorPage ?: new Error;
    }

    /**
     * (non-PHPdoc)
     *
     * @see BEAR\Sunday\Exception.ExceptionHandlerInterface::handle()
     */
    public function handle(Exception $e)
    {
        error_log($e);
        $exceptionId = 'e' . substr(md5((string)$e), 0, 5);
        $this->writeExceptionLog($e, $exceptionId);
        $page = $this->buildErrorPage($e, $exceptionId, $this->errorPage);
        $this->response->setResource($page)->render()->prepare()->send();
        exit(1);
    }

    /**
     * Return error page
     *
     * @param $e
     * @param $exceptionId
     *
     * @return \BEAR\Sunday\Resource\Page\Error
     * @throws
     */
    private function buildErrorPage($e, $exceptionId, ResourceObject $response)
    {
        try {
            throw $e;
        } catch (ResourceNotFound $e) {
            $response->code = 404;
            $response->view = $this->message['ResourceNotFound'];
            goto NOT_FOUND;
        } catch (BadRequest $e) {
            $response->code = 400;
            $response->view = $this->message['BadRequest'];
            goto METHOD_NOT_ALLOWED;
        } catch (Parameter $e) {
            $response->code = 400;
            $response->view = $this->message['Parameter'];
            goto BAD_REQUEST;
        } catch (Scheme $e) {
            $response->code = 400;
            $response->view = $this->message['Scheme'];
            goto BAD_REQUEST;
        } catch (MethodNotAllowed $e) {
            $response->code = 405;
            $response->view = $this->message['MethodNotAllowed'];
            goto METHOD_NOT_ALLOWED;
        } catch (Binding $e) {
            goto INVALID_BINDING;
        } catch (Uri $e) {
            $response->code = 400;
            goto INVALID_URI;
        } catch (Exception $e) {
            goto SERVER_ERROR;
        }

        INVALID_BINDING:
        SERVER_ERROR:
        $response->code = 500;

        NOT_FOUND:
        BAD_REQUEST:
        METHOD_NOT_ALLOWED:
        INVALID_URI:

        if (PHP_SAPI === 'cli') {
            $response->view = "Internal error occurred ({$exceptionId})";
        } else {
            $response->view = $this->getView($e);
        }
        $response->headers['X-EXCEPTION-CLASS'] = get_class($e);
        $response->headers['X-EXCEPTION-MESSAGE'] = str_replace(PHP_EOL, ' ', $e->getMessage());
        $response->headers['X-EXCEPTION-CODE'] = $e->getCode();
        $response->headers['X-EXCEPTION-FILE-LINE'] = $e->getFile() . ':' . $e->getLine();
        $previous = $e->getPrevious() ? (
            get_class($e->getPrevious()) . ': ' . str_replace(PHP_EOL, ' ', $e->getPrevious()->getMessage())) : '-';
        $response->headers['X-EXCEPTION-PREVIOUS'] = $previous;
        $response->headers['X-EXCEPTION-ID'] = $exceptionId;
        $this->writeExceptionLog($e, $exceptionId);

        return $response;
    }

    private function getView($e)
    {
        // exception screen in develop
        if (isset($this->injector)) {
            $dependencyBindings = (string) $this->injector;
            $modules = $this->injector->getModule()->modules;
        } elseif (isset($e->module)) {
            $dependencyBindings = (string) $e->module;
            $modules = $e->module->modules;
        } else {
            $dependencyBindings = 'n/a';
            $modules = 'n/a';
        }
        return include $this->viewTemplate;

    }

    /**
     * Write exception logs
     *
     * @param Exception $e
     * @param string    $exceptionId
     */
    public function writeExceptionLog(Exception $e, $exceptionId)
    {
        $filename = "e.{$exceptionId}.log";
        $data = PHP_EOL . $e->getTraceAsString();
        $previousE = $e->getPrevious();
        if ($previousE) {
            $data .= PHP_EOL . PHP_EOL . '-- Previous Exception --' . PHP_EOL . PHP_EOL;
            $data .= $previousE->getTraceAsString();
        }
        $data .= (string)$e;
        $file = "{$this->logDir}/" . $filename;
        if (is_writable($file)) {
            file_put_contents($file, $data);
        }
    }
}
