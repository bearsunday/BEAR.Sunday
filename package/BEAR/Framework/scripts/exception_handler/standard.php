<?php
/**
 * Exception handler
 */
namespace BEAR\Framework\scripts\excection_handler;

use BEAR\Resource\Exception\BadRequest;
use BEAR\Resource\Exception\MethodNotAllowed;
use BEAR\Resource\Exception\InvalidParameter;
use BEAR\Resource\Exception\InvalidScheme;
use BEAR\Resource\Exception\ResourceNotFound;
use Ray\Di\Exception\InvalidBinding;
use BEAR\Framework\Resource\Page\Error;
use BEAR\Framework\Web\HttpFoundation as Output;

set_exception_handler(function(\Exception $e) {
	global $_xhprof;
	
    $mode = isset($_ENV['BEAR_OUTPUT_MODE']) ? $_ENV['BEAR_OUTPUT_MODE'] : 'prod';
    $exceptionId = 'e' . substr(md5((string)$e), 0, 5);
    try {
        $response = new Error;
        throw $e;
    } catch (NotFound $e) {
        $response->code = 404;
        $response->body = 'The requested URI was not found on this service.';
        goto NOT_FOUND;
    } catch (BadRequest $e) {
        $response->code = 400;
        $response->body = 'You sent a request that this service cound not understand.';
        goto METHOD_NOT_ALLOWED;
    } catch (InvalidParameter $e) {
        $response->code = 400;
        $response->body = 'You sent a request that query is not valid.';
        goto BAD_REQUEST;
    } catch (InvalidScheme $e) {
        $response->code = 400;
        $response->body = 'You sent a request that scheme is not valid.';
        goto BAD_REQUEST;
    } catch (MethodNotAllowed $e) {
        $response->code = 405;
        $response->body = 'The requested method is not allowed for this URI.';
        goto METHOD_NOT_ALLOWED;
    } catch (ResourceNotFound $e) {
        $response->code = 404;
        $response->body = 'The requested URI was not found on this service.';
        goto NOT_FOUND;
    } catch (InvalidBinding $e) {
        goto INVALID_BINDING;
    } catch (\Exception $e) {
        goto SERVER_ERROR;
    }

OK:
    (new Output)->setResource($response)->prepare()->output();
    exit(0);

INVALID_BINDING:
SERVER_ERROR:
    $response->code = 500;
	if (PHP_SAPI === 'cli') {
    	$response->body = "Internal error occured ({$exceptionId})";
	} else {
		// exception screen in develop
	    $response->body = include __DIR__ . "/exception.tpl.php";
	}
NOT_FOUND:
BAD_REQUEST:
METHOD_NOT_ALLOWED:
    $response->headers['X-EXCEPTION-CLASS'] = get_class($e);
    $response->headers['X-EXCEPTION-MESSAGE'] = str_replace("\n", ' ', $e->getMessage());
    $response->headers['X-EXCEPTION-CODE'] = $e->getCode();
    $response->headers['X-EXCEPTION-FILE-LINE'] = $e->getFile() . ':' . $e->getLine();
    $previous =  $e->getPrevious() ? (get_class($e->getPrevious()) .': ' . str_replace("\n", ' ', $e->getPrevious()->getMessage())) : '-';
    $response->headers['X-EXCEPTION-PREVIOUS'] =  $previous;
    $response->headers['X-EXCEPTION-ID'] = $exceptionId;
    (new Output)->setResource($response)->setException($e, $exceptionId)->prepare(false)->send();
    exit(1);
});
