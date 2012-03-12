<?php
/**
 * Exception handler
 */
namespace BEAR\Framework;

use BEAR\Framework\Exception\ResourceNotFound;
use BEAR\Resource\Exception\BadRequest,
    BEAR\Resource\Exception\MethodNotAllowed,
    BEAR\Resource\Exception\InvalidParameter,
    BEAR\Resource\Exception\InvalidScheme;

use Ray\Di\Exception\InvalidBinding;
use demoworld\Resource\Page\Code;

use BEAR\Framework\Output\HttpFoundation as Output;

set_exception_handler(function(\Exception $e) {
    $mode = isset($_ENV['BEAR_OUTPUT_MODE']) ? $_ENV['BEAR_OUTPUT_MODE'] : 'prod';
    try {
        $response = new Code;
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
        $response->headers['X-EXCEPTION'] = get_class($e);
        $response->headers['X-EXCEPTION-CODE'] = $e->getCode();
        $response->headers['X-EXCEPTION-MESSAGE'] = $e->getMessage();
        $response->body = 'The requested URI was not found on this service.';
        goto NOT_FOUND;
    } catch (InvalidBinding $e) {
        $response->code = 500;
        $response->headers['X-EXCEPTION'] = get_class($e);
        $response->headers['X-EXCEPTION-MESSAGE'] = $e->getMessage();
        $response->body = 'Biding is invalid. Check the module.';
    } catch (\Exception $e) {
        $response->code = 500;
        $response->headers['X-EXCEPTION'] = get_class($e);
        $response->headers['X-EXCEPTION-CODE'] = $e->getCode();
        $response->headers['X-EXCEPTION-MESSAGE'] = $e->getMessage();
        $response->body = print_r($e->getTrace()[1] , true);
        goto SERVER_ERROR;
    }

OK:
    (new Output)->setResource($response)->prepare()->output();
    exit(0);

NOT_FOUND:
BAD_REQUEST:
METHOD_NOT_ALLOWED:
SERVER_ERROR:
    (new Output)->setResource($response)->setException($e)->output();
    exit(1);
});