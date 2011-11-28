<?php

namespace helloworld\ResourceObject\Greeting;

use BEAR\Resource\Object as ResourceObject,
    BEAR\Resource\AbstractObject;

/**
 * Greeting resource with @Log
 *
 * @Aspect
 */
class Aop extends AbstractObject
{
    /**
     * Greeting message
     *
     * @var array
     */
    private $messsage;

    /**
     * Constructor
     *
     * @param array $message
     *
     * @Inject
     * @Named("message=GreetingMessage")
     */
    public function __construct(array $message)
    {
        $this->message = $message;
    }

    /**
     * Get
     *
     * @param string $lang language
     * @return string
     *
     * @Log
     */
    public function onGet($lang)
    {
        $greeting = $this->message[$lang];
        return $greeting;
    }
}
