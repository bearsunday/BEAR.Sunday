---
layout: default
title: BEAR.Sunday | Application Object 
category: Application
---
# Application Object

The application object is an object that holds all of the service objects used by the application script to regulate the application runtime.


# Application Class 

Below an application class with minimal configuration.

```
use BEAR\Sunday\Extension\Application\AppInterface;

final class App implements Context
{
    public $resource;
    public $response;
    public $logger;

    /**
     * Constructor
     *
     * @param ResourceInterface $resource Resource client
     * @param ResponseInterface $response Web / Console response
     * @param ApplicationLogger $logger   Application logger
     *
     * @Inject
     */
    public function __construct
        ResourceInterface $resource,
        ResponseInterface $response,
        ApplicationLogger $logger
    ) {
        $this->resource = $resource;
        $this->response = $response;
        $this->logger = $logger;
        $resource->attachParamProvider('Provides', new Provides);
    }
}
```

The resource client, response and logger needed by the application script is passed to the constructor and is stored into their respective properties.

The relevant objects are injected for each interface according to the application configuration. For example when using a development configuration the development resource client provides more debugging information, in an API based application rather than have HTML output a component that outputs JSON+HAL(or just JSON) is used.

This class provides an instance through the instance script.