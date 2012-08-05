<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Web;

use BEAR\Framework\Exception\InvalidResourceType;
use BEAR\Framework\Inject\LogInject;
use BEAR\Resource\Request;
use BEAR\Resource\Object as ResourceObject;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\FormatterHelper as Formatter;
use Ray\Aop\Weave;
use Ray\Di\Di\Inject;
use Exception;
use Traversable;
/**
 * Output with using symfony HttpFoundation
 *
 * @package    BEAR.Framework
 * @subpackage Web
 */
class SymfonyResponse implements ResponseInterface
{
    use LogInject;

    const MODE_REQUEST = 'request';
    const MODE_VIEW    = 'view';
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
     * @var BResourceObject
     */
    private $resource;

    /**
     * Response resource object
     *
     * @var Response
     */
    private $response;

    /**
     * Mode
     *
     * @param string $mode
     */
    private $mode;

    /**
     * Set Resource
     *
     * @param mixed $resource BEAR\Rsource\Object | Ray\Aop\Weaver $resource
     *
     * @throws InvalidResourceType
     * @return \BEAR\Framework\Web\SymfonyResponse
     */
    public function setResource($resource)
    {
        if ($resource instanceof Weave) {
            $resource = $resource->___getObject();
        }
        if ($resource instanceof ResourceObject === false && $resource instanceof Weave === false) {
            $type = (is_object($resource)) ? get_class($resource) : gettype($resource);
            throw new InvalidResourceType($type);
        }
        $this->resource = $resource;

        return $this;
    }

    /**
     * Set Excpection
     *
     * @param Exception $e
     *
     * @return \BEAR\Framework\Web\SymfonyResponse
     */
    public function setException(Exception $e, $exceptionId)
    {
        $this->e = $e;
        $this->code = $e->getCode();
        $this->headers = [];
        $this->body = $exceptionId;

        return $this;
    }

    /**
     * Render
     *
     * @param Callback $renderer
     *
     * @return self
     */
    public function render(Callback $renderer = null)
    {
        if (is_callable($renderer)) {
            $this->view = $renderer($this->body);
        } else {
            // __toString() method suppoesed to create own view.
            $this->view = (string) $this->resource;
        }

        return $this;
    }

    /**
     * Make responce object with RFC 2616 compliant HTTP header
     *
     * @return \BEAR\Framework\Web\SymfonyResponse
     */
    public function prepare()
    {
        $this->response = new Response($this->view, $this->resource->code, (array) $this->resource->headers);
        // compliant with RFC 2616.
        $this->response->prepare();

        return $this;
    }

    /**
     * Send
     *
     * @return \BEAR\Framework\Web\SymfonyResponse
     */
    public function send()
    {
        if (PHP_SAPI === 'cli') {
            $this->sendCli();
        } else {
            $this->response->send();
        }

        return $this;
    }

    public function sendCli($mode = self::MODE_VIEW)
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
        $codeMsg = $label . $this->resource->code . ' ' . Response::$statusTexts[$this->resource->code] . $close . PHP_EOL;
        echo $codeMsg;
        // hedaers
        if ($this->response) {
            // prepared HTTP headers
            foreach ($this->response->headers->all() as $name => $values) {
                foreach ($values as &$value) {
                    if (is_array($value)) {
                        $value = json_encode($value);
                    }
                    echo "{$label1}{$name}: {$close}{$value}" . PHP_EOL;
                }
            }
        } else {
            // resource headers
            foreach ($this->resource->headers as $name => $value) {
                $value = (is_array($value)) ? print_r($value, true) : $value;
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
                            $body = "{$label2}" . $body->toUri() .$close;
                            break;
                        case self::MODE_VALUE:
                            $value = $body();
                            $body = var_export($value, true) . " {$label2}" . $body->toUri() . $close;
                            break;
                        case self::MODE_VIEW:
                        default:
                            $body = (string) $body . " {$label2}" . $body->toUri() . $close;
                            break;

                    }
                }
                $body = is_array($body) ? var_export($body, true) : $body;
                echo "{$label1}{$key}{$close}:" . $body. PHP_EOL;
            }
        } else {
            $body = $this->resource->view ?: $this->resource->body;
            echo $body;
        }
        echo PHP_EOL;
    }
}
