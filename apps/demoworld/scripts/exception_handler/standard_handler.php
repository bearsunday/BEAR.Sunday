<?php
/**
 * Exception handler
 */
namespace BEAR\Framework;

    use BEAR\Framework\Exception\ResourceNotFound;
use BEAR\Resource\Exception\BadRequest;
use demoworld\Page\Code;

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
        $response->headers['X-EXCEPTION'] = get_class($e);
        $response->headers['X-EXCEPTION-CODE'] = $e->getCode();
        $response->headers['X-EXCEPTION-MESSAGE'] = $e->getMessage();
        $response->body = 'The requested URI was not found on this service.';
        goto NOT_FOUND;
    } catch (\Exception $e) {
        $response->code = 500;
        $response->headers['X-EXCEPTION'] = get_class($e);
        $response->headers['X-EXCEPTION-CODE'] = $e->getCode();
        $response->headers['X-EXCEPTION-MESSAGE'] = $e->getMessage();
        $response->headers['X-EXCEPTION-TRACE0'] = json_encode($e->getTrace()[0]);
        $response->headers['X-EXCEPTION-TRACE1'] = json_encode($e->getTrace()[1]);
        $response->body = '<div class="trace">' . $e->getTraceAsString() . '</div>';
        $response->body = '<div class="trace">' . $e->getTraceAsString() . '</div>';
        goto SERVER_ERROR;
    }

OK:
    include dirname(__DIR__) . '/output/prod.output.php';
    exit(0);

NOT_FOUND:
BAD_REQUEST:
METHOD_NOT_ALLOWED:
SERVER_ERROR:
    include dirname(__DIR__) . "/output/{$mode}.output.php";
    exit(1);
}
);
