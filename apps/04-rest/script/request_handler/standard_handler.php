<?php

if (!($response instanceof $ro)) {
    $ro->body = $response;
    $response = $ro;
}
?>