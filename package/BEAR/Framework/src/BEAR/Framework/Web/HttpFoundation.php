<?php
/**
 * Response
 *
 * @package BEAR.Framework
 */
namespace BEAR\Framework\Web;

use BEAR\Resource\Object as ResourceObject;
use BEAR\Framework\Exception\ResourceBodyIsNotString;
use BEAR\Framework\Exception\InvalidResourceType;
use BEAR\Resource\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\FormatterHelper as Formatter;
use Ray\Aop\Weaver;
use Exception;
use Traversable;
use BEAR\Framework\Inject\LogInject;
use BEAR\Framework\Inject\TmpDirInject;
use BEAR\Framework\Inject\LogDirInject;

/**
 * Output with Symfony HttpFoundation
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class HttpFoundation implements Response
{
    use LogInject;
    use TmpDirInject;
    use LogDirInject;

    const FORMAT_JSON      = 'json';
    const FORMAT_SERIALIZE = 'serialize';
    const FORMAT_VAREXPORT = 'varexport';
    const FORMAT_VARDUMP   = 'vardump';
    const FORMAT_PRINTR    = 'printr';
    const FORMAT_REP       = 'rep';

    const MODE_REQUEST = 'requrest';
    const MODE_REP     = 'rep';
    const MODE_VALUE   = 'value';

    /**
     * Exception
     *
     * @var Exception
     */
    private $e;

    /**
     * Resource object
     *
     * @var BEAR\Resource\Object
     */
    private $resource;

    /**
     * Response resource object
     *
     * @var BEAR\Resource\Object
     */
    private $response;


    private $headers = [];
    private $debug = true;

    /**
     * Set Resource
     *
     * @param BEAR\Rsource\Object | Ray\Aop\Weaver $resource
     *
     * @throws InvalidResourceType
     * @return \BEAR\Framework\Web\HttpFoundation
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
     * Set log dir
     *
     * @Inject(optional = true)
     */
    public function setLogDir($logDir)
    {
        $this->logDir = $logDir;
        return $this;
    }

    /**
     * Add debug information to header
     *
     * @return \BEAR\Framework\Web\HttpFoundation
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
     * @return \BEAR\Framework\Web\HttpFoundation
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
     * @return \BEAR\Framework\Web\HttpFoundation
     */
    public function prepare()
    {
        // already has representation ?
        if ($this->resource->representation) {
            $body = $this->resource->representation;
            goto complete;
        }
        // if not, make resource representation by rendering with template
        if (! $this->e instanceof \Exception) {
            // be string
            (string)($this->resource);
        }
        // if stil not has a representation (string), throw exception.
        if (! is_string($this->resource->body)) {
            $type = is_object($this->resource->body) ? get_class($this->resource->body) : gettype($this->resource->body);
            $this->log("ResourceBodyIsNotString[{$this->resource->body}]");
            throw new ResourceBodyIsNotString($type);
        }
        $body = $this->resource->body;

        complete:
        $this->response = new SymfonyResponse($body, $this->resource->code, (array) $this->resource->headers);
        // compliant with RFC 2616.
        $this->response->prepare();
        return $this;
    }

    /**
     * Send
     *
     * @return \BEAR\Framework\Web\HttpFoundation
     */
    public function send($mode = self::MODE_REP)
    {
        if (PHP_SAPI === 'cli') {
            $this->outputCliDebug($mode);
        } else {
            $this->outputWeb();
        }
        if ($this->debug === true && $this->e) {
            $filename = str_replace('\\', '_', get_class($this->e));
            $filename = ".expection.{$filename}.{$this->exceptionId}.log";
            ob_start();
            $trace = $this->e->getTrace();
            $data = print_r($trace[0], true) . "\n" . $this->e->getTraceAsString();
            $previousE = $this->e->getPrevious();
            if ($previousE) {
                $data .= PHP_EOL . PHP_EOL . '-- Previous Exception --' . PHP_EOL . PHP_EOL;
                $data .= $previousE->getTraceAsString();
            }
            $this->log($filename, $data);
            $lasLog = '.expection.log';
            if (is_writable($filename)) {
                if (file_exists($lasLog)) {
                    unlink($lasLog);
                }
                symlink($filename, $lasLog);
            }
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

    public function outputCliDebug($mode)
    {
        if ($this->e) {
            $consoleOutput = new ConsoleOutput;
            $msg = $this->e->getMessage();
            $consoleOutput->writeln([
                '',
                (new Formatter)->formatBlock(get_class($this->e). ': ' . $msg, 'bg=red;fg=white', true),
                '',
                ]);
        }
        $label = "\033[1;32m";
        $label1 = "\033[1;33m";
        $label2 = "\e[4;30m";
        $label3 = "\e[0;36m";
        $close = "\033[0m";
        // code
        $codeMsg = $label . $this->resource->code . ' ' . SymfonyResponse::$statusTexts[$this->resource->code] . $close . PHP_EOL;
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
        // body label
        echo "{$label}[BODY]{$close}" . PHP_EOL;
        $isTraversable = is_array($this->resource->body) || $this->resource->body instanceof \Traversable;
        if ($isTraversable) {
            foreach ($this->resource->body as $key => $body) {
                if ($body instanceof \BEAR\Resource\Request) {
                    switch ($mode) {
                        case self::MODE_REQUEST:
                            $body = "{$label2}(Request)" . $body->toUri() .$close;
                            break;
                        case self::MODE_VALUE:
                            $resource = $body();
                            $body = var_export($resource->body, true) . "{$label2}by " . $body->toUri() . $close;
                            break;
                        case self::MODE_REP:
                        default:
                            $body = (string)$body . "{$label2}by " . $body->toUri() . $close;
                            break;

                    }
                }
                $body = is_array($body) ? var_export($body, true) : $body;
                echo "{$label1}{$key}{$close}:" . $body. PHP_EOL;
            }
        } else {
            $body = $this->resource->representation ?: $this->resource->body;
            echo $body;
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
        $this->log('.trace.log', $log);
        $this->log('.trace.log.' . get_class($e) . md5(serialize($e->getTrace())), $log);
    }

    /**
     * Execute in-resource request
     *
     * @return \BEAR\Framework\Web\HttpFoundation
     */
    public function request()
    {
        //         (string)$this->resource;
        return $this;
    }

    /**
     * Convert format
     *
     * @param mixed $format
     *
     * @return \BEAR\Framework\Web\HttpFoundation
     */
    public function format($format)
    {
        if (is_callable($format)) {
            $this->resource->body = $format($this->resource->body);
            return $this;
        }
        switch ($format) {
            case self::FORMAT_JSON:
                $this->resource->representation = json_encode($this->resource->body);
                break;
            case self::FORMAT_VAREXPORT:
                $this->resource->representation = var_export($this->resource->body, true);
                break;
            case self::FORMAT_VARDUMP:
                ob_start();
                var_export($this->resource->body);
                $this->resource->representation = ob_get_contents();
                ob_end_clean();
                break;
            case self::FORMAT_PRINTR:
                $this->resource->representation = print_r($this->resource->body, true);
                break;
            case self::FORMAT_SERIALIZE:
                $this->resource->representation = serialize($this->resource->body);
                break;
            default:
                throw Exception($format);
                break;
        }
        return $this;
    }

    private function log($filename, $log)
    {
        $file = "{$this->logDir}/" . $filename;
        if (is_writable($file)) {
            file_put_contents($file, $log);
        }
        error_log("[$filename]$log");
    }
}
