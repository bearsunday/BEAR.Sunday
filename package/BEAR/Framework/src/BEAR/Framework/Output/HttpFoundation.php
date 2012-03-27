<?php

/**
 * @package BEAR.Framework
 */
namespace BEAR\Framework\Output;

use BEAR\Resource\Object as ResourceObject;
use BEAR\Framework\Exception\ResourceBodyIsNotString;
use BEAR\Framework\Exception\InvalidResourceType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\FormatterHelper as Formatter;
use Ray\Aop\Weaver;

use Exception;
use Traversable;

/**
 * Output with Symfony HttpFoundation
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class HttpFoundation implements Outputtable
{
    const FORMAT_JSON = 0;
    const FORMAT_SERIALIZE = 1;
    const FORMAT_VAREXPORT = 2;
    const FORMAT_VARDUMP   = 3;
    const FORMAT_PRINTR    = 4;

    private $e;
    private $resource;
    private $response;
    private $headers = [];
    private $debug = true;

    /**
     * Set Resource
     *
     * @param BEAR\Rsource\Object | Ray\Aop\Weaver $resource
     *
     * @throws InvalidResourceType
     * @return \BEAR\Framework\Output\HttpFoundation
     */
    public function setResource($resource)
    {
        if ($resource instanceof ResourceObject === false && $resource instanceof Weaver === false) {
            $type = (is_object($resource)) ? get_class($resource) : gettype($resource);
            throw new InvalidResourceType($type);
        }
        $this->resource = $resource;
        return $this;
    }

    /**
     * Add debug information to header
     *
     * @return \BEAR\Framework\Output\HttpFoundation
     */
    public function debug()
    {
        $this->debug = true;
        if (isset($_SERVER['REQUEST_TIME_FLOAT'])) {
            $this->headers['X-Request-Per-Second'] = number_format((1 / (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'])), 2);
            $this->headers['X-Memory-Peak-Usage'] = number_format(memory_get_peak_usage(true));
        }
        return $this;
    }

    /**
     * Set Excpection
     *
     * @param Exception $e
     *
     * @return \BEAR\Framework\Output\HttpFoundation
     */
    public function setException(Exception $e, $exceptionId)
    {
        $this->e = $e;
        $this->exceptionId = $exceptionId;
        return $this;
    }

    /**
     * Make responce object with RFC 2616 compliant HTTP header
     *
     * @throws ResourceBodyIsNotString
     * @return \BEAR\Framework\Output\HttpFoundation
     */
    public function prepare()
    {
        if (! is_string($this->resource->body)) {
            $type = is_object($this->resource->body) ? get_class($this->resource->body) : gettype($this->resource->body);
            throw new ResourceBodyIsNotString($type);
        }
        $this->response = new Response($this->resource->body, $this->resource->code, (array) $this->resource->headers);
        // compliant with RFC 2616.
        $this->response->prepare();
        return $this;
    }

    /**
     * Output
     *
     * @param boolean $debug
     *
     * @return void
     */
    public function output($debug = true)
    {
        if (PHP_SAPI === 'cli') {
            $this->outputCliDebug();
        } else {
            $this->outputWeb();
        }
        if ($debug === true && $this->e) {
            $filename = str_replace('\\', '_', get_class($this->e));
            $filename = ".expection.{$filename}.{$this->exceptionId}.log";
            ob_start();
            $data = print_r($this->e->getTrace(), true);
            file_put_contents($filename, $data);
            $lasLog = '.expection.log';
            if (file_exists($lasLog)) {
                unlink($lasLog);
            }
            symlink($filename, $lasLog);
        }
        return $this;
    }

    /**
     * Output web
     *
     * @return void
     */
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

    /**
     * Write expection as file.
     *
     * @return void
     */
    private function writeException()
    {
        $log = print_r($this->e->getTrace(), true);
        file_put_contents('.trace.log', $log);
        file_put_contents('.trace.log.' . get_class($e) . md5(serialize($e->getTrace())), $log);
    }

    /**
     * Execute in-resource request
     *
     * @return \BEAR\Framework\Output\HttpFoundation
     */
    public function request()
    {
        if (is_array($this->resource->body) || $this->resource->body instanceof \Traversable) {
            foreach ($this->resource->body as $key => &$value) {
//                 if (is_callable($value) === true) {
//                     $value = $value()->body;
//                 }
            }
        }
        return $this;
    }

    /**
     * Convert format
     *
     * @param string | Callable  $format
     *
     * @return \BEAR\Framework\Output\HttpFoundation
     */
    public function be($format)
    {
        if (is_callable($format)) {
            $this->resource->body = $format($this->resource->body);
            return $this;
        }
        switch ($format) {
            case self::FORMAT_JSON:
                $this->resource->body = json_encode($this->resource->body);
                break;
            case self::FORMAT_VAREXPORT:
                $this->resource->body = var_export($this->resource->body, true);
                break;
            case self::FORMAT_VARDUMP:
                ob_start();
                var_export($this->resource->body);
                $this->resource->body = ob_get_contents();
                ob_end_clean();
                break;
            case self::FORMAT_PRINTR:
                $this->resource->body = print_r($this->resource->body, true);
                break;
            case self::FORMAT_SERIALIZE:
                $this->resource->body = serialize($this->resource->body);
                break;
            default:
                throw Exception($format);
            break;
        }
        return $this;
    }
}
