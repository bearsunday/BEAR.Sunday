<?php

namespace BEAR\Resource\Exception;

set_exception_handler(function(\Exception $e) {
    try {
        $http = new \helloWorld\Page\Code;
        throw $e;
    } catch (BadRequest $e) {
        $http->code = 400;
        $http->body = 'You sent a request that this server cound not understand.';
        include __DIR__ . '/dev.output.php';
    } catch (MethodNotAllowed $e) {
        $http->code = 405;
        $http->body = 'The requested method is not allowed for this URI.';
        include __DIR__ . '/dev.output.php';
        exit(1);
    } catch (\Exception $e) {
        $http->code = 500;
        $http->body = (string)$e;
    }
    include __DIR__ . '/dev.output.php';
}
);

