<?php
namespace BEAR\Framework\HelloWorld;

use BEAR\Resource\ResourceObject\Resource,
    BEAR\Resource\ResourceObject\Page,
    BEAR\Resource\Cleint;

/**
 * QueryWorld by query
 */
class DefaultHttp extends View
{
    public function onGet(Ro $ro)
    {
        foreach ($this->header as $value) {
            if ($value instanceof Request || $value instanceof \Closure) {
                $value = $value();
            }
            header($value);
        }
        echo $this->body;
    }
}