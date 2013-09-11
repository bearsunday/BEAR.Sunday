---
layout: default
title: BEAR.Sunday | Application Script 
category: Application
---
# Application Script

Instead of the framework having a set execution flow, in BEAR.Sunday an application script expresses what kind of flow the application follows. 

In order to change this flow directly edit the application script.

# Application Script 

Below is a production script for the `Sandbox` application.

```
// Application instance with loader
$mode = 'Prod';
$app = require dirname(__DIR__) . '/scripts/instance.php';

// Dispatch
list($method, $pagePath, $query) = $app->router->match($GLOBALS);

// Request
try {
    $app->page = $app->resource->$method->uri('page://self/' . $pagePath)->withQuery($query)->eager->request();
} catch (NotFound $e) {
    $code = 404;
    goto ERROR;
} catch (BadRequest $e) {
    $code = 400;
    goto ERROR;
} catch (Exception $e) {
    $code = 503;
    error_log((string)$e);
    goto ERROR;
}

// Transfer

OK: {
    $app->response->setResource($app->page)->render()->prepare()->send();
    exit(0);
}

ERROR: {
    http_response_code($code);
    require dirname(__DIR__) . "/http/{$code}.php";
    exit(1);
}
```

The application object is retrieved from the the application instance script. The application object holds all of the service objects and properties needed by the application script.

## About the Script 

### Retrieve the application instance 
```
$mode = 'Prod';
$app = require dirname(__DIR__) . '/scripts/instance.php';
```
Retrieve the application object from the application instance script. In this script the class loading settings are run.

### Dispatch 
```
// Dispatch
list($method, $pagePath, $query) = $app->router->match($GLOBALS);
```
The request method, URI and query for the resource are retrieved from the global variable.

### Page resource request and output 

Then using these variables the page request is made. The page output is then different depending on wether an OK or an ERROR is reached.