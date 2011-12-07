<?php

namespace BEAR\Resource\Exception;

use Aura\Autoload\Exception\NotFound;
use BEAR\Resource\Exception\BadRequest;

set_exception_handler(function(\Exception $e) {
    try {
        include_once dirname(dirname(__DIR__)) . '/Page/Code.php';
        $response = new \restWorld\Page\Code;
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
    } catch (\Exception $e) {
        $response->code = 500;
        $response->headers['X-EXCEPTION'] = get_class($e);
        $response->headers['X-EXCEPTION-CODE'] = $e->getCode();
        $response->headers['X-EXCEPTION-MESSAGE'] = $e->getMessage();
        $response->body = '<div class="trace">' . $e->getTraceAsString() . '</div>';
        goto SERVER_ERROR;
    }

OK:
    include dirname(__DIR__) . '/output/dev.output.php';
    exit(0);

NOT_FOUND:
BAD_REQUEST:
METHOD_NOT_ALLOWED:
SERVER_ERROR:
    include dirname(__DIR__) . '/output/dev.output.php';
    exit(1);
}
);

