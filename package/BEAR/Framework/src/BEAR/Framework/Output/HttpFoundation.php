<?php

/**
 * @package BEAR.Framework
 */
namespace BEAR\Framework\Output;

use BEAR\Resource\Object as ResourceObject;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\FormatterHelper as Formatter;

/**
 * Output with Symfony HttpFoundation
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class HttpFoundation implements Outputtable
{
    private $e;
    private $resource;
    private $response;
    private $headers = [];
    private $debug = true;

    public function setResource(ResourceObject $resource)
    {
        $this->resource = $resource;
        return $this;
    }

    public function debug()
    {
        $this->debug = true;
        if (isset($_SERVER['REQUEST_TIME_FLOAT'])) {
            $this->headers['X-Request-Per-Second'] = number_format((1 / (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'])), 2);
            $this->headers['X-Memory-Peak-Usage'] = number_format(memory_get_peak_usage(true));
        }
        return $this;
    }

    public function setException(Exception $e)
    {
        $this->e = $e;
        return $this;
    }

    public function prepare()
    {
        $this->response = new Response($this->resource->body, $this->resource->code, (array) $this->resource->headers);
        // compliant with RFC 2616.
        $this->response->prepare();
        return $this;
    }

    public function toString($body)
    {
        return "body";
    }

    public function output($debug = true)
    {
        if (PHP_SAPI === 'cli') {
            $this->outputCliDebug();
        } else {
            $this->outputWeb();
        }
    }

    public function outputWeb()
    {
       $this->response->send();
    }

    public function outputCliDebug()
    {
        $consoleOutput = new ConsoleOutput;
        if ($this->e) {
           $msg = $this->e->getMessage();
           $consoleOutput->writeln([
                    '',
                    (new Formatter)->formatBlock(get_class($this->e). ': ' . $msg, 'bg=red;fg=white', true),
                    '',
            ]);
        }
        $label = "\033[1;32m";
        $label1 = "\033[1;33m";
        $close = "\033[0m";
        // code
        $codeMsg = $label . $this->resource->code . ' ' . Response::$statusTexts[$this->resource->code] . $close . PHP_EOL;
        echo $codeMsg;
        // hedaers
        if ($this->response) {
            // prepared HTTP headers
            foreach ($this->response->headers->all() as $name => $values) {
                foreach ($values as $value) {
                    echo "{$label1}{$name}: {$close}{$value}" . PHP_EOL;
                }
            }
        } else {
            // resource headers
            foreach ($this->resource->headers as $name => $value) {
                echo "{$label1}{$name}: {$close}{$value}" . PHP_EOL;
            }
        }
        // body
        echo "{$label}[BODY]{$close}" . PHP_EOL;
        if (is_array($this->resource->body) || $this->resource->body instanceof \Traversal) {
            foreach ($this->resource->body as $key => $body) {
                $body = is_array($body) ? json_encode($body) : $body;
                echo "{$label1}{$key}{$close}:" . $body. PHP_EOL;
            }
        } else {
            echo $this->resource->body;
        }
        echo PHP_EOL;
    }

    private function writeException()
    {
        $log = print_r($this->e->getTrace(), true);
        file_put_contents('.trace.log', $log);
        file_put_contents('.trace.log.' . get_class($e) . md5(serialize($e->getTrace())), $log);
    }
}