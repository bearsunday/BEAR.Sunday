<?php
/**
 * Exception handler
 */
namespace BEAR\Framework;

use BEAR\Framework\Exception\ResourceNotFound;
use BEAR\Resource\Exception\BadRequest,
    BEAR\Resource\Exception\MethodNotAllowed;
use Ray\Di\Exception\InvalidBinding;

use demoworld\Resource\Page\Code;

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
    } catch (MethodNotAllowed $e) {
        $response->code = 405;
        $response->body = 'The requested method is not allowed for this URI.';
        goto METHOD_NOT_ALLOWED;
    } catch (ResourceNotFound $e) {
        $response->code = 404;
        $response->body = 'The requested URI was not found on this service.';
        goto NOT_FOUND;
    } catch (InvalidBinding $e) {
        $response->code = 500;
        $response->body = 'Biding is invalid. Check the module.';
    } catch (\Exception $e) {
        $response->code = 503;
        $response->body = '<h1>503 Service Unavailable</h1>';
        goto SERVER_ERROR;
    }

OK:
    include dirname(__DIR__) . '/output/prod.output.php';
    exit(0);

NOT_FOUND:
BAD_REQUEST:
METHOD_NOT_ALLOWED:
SERVER_ERROR:
    error_log((string)$e);
    include dirname(__DIR__) . "/output/prod.output.php";
    exit(1);
}
);
