<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Output;

use BEAR\Resource\Object as ResourceObject;
use Symfony\Component\Console\Output\ConsoleOutput;
use Guzzle\Parser\UriTemplate\UriTemplate;

/**
 * Cli Output
 *
 * @package    BEAR.Sunday
 * @subpackage Web
 */
final class Console implements ConsoleInterface
{
    const MODE_REQUEST = 'request';
    const MODE_VIEW = 'view';
    const MODE_VALUE = 'value';

    /**
     * Console output
     *
     * @var \Symfony\Component\Console\Output\ConsoleOutput
     */
    private $console;

    /**
     * Send CLI output
     *
     * @param ResourceObject $resource
     * @param \Exception     $e
     * @param string         $statusText
     * @param string         $mode
     */
    public function send(
        ResourceObject $resource,
        \Exception $e = null,
        $statusText = '',
        $mode = self::MODE_VIEW
    ) {
        if ($e) {
            $consoleOutput = $this->console;
            $msg = $e->getMessage();
            $consoleOutput->writeln(
                [
                    '',
                    (new Formatter)->formatBlock(get_class($e) . ': ' . $msg, 'bg=red;fg=white', true),
                    '',
                ]
            );
        }
        $label = "\033[1;32m";
        $label1 = "\033[1;33m";
        $label2 = "\e[4;30m";
        $close = "\033[0m";
        // code
        $codeMsg = $label . $resource->code . ' ' . $statusText . $close . PHP_EOL;
        echo $codeMsg;
        // headers
        if (0) {
            // prepared HTTP headers
            foreach ($resource->headers as $name => $values) {
                foreach ($values as &$value) {
                    if (is_array($value)) {
                        $value = json_encode($value);
                    }
                    echo "{$label1}{$name}: {$close}{$value}" . PHP_EOL;
                }
            }
        } else {
            // resource headers
            foreach ($resource->headers as $name => $value) {
                $value = (is_array($value)) ? json_encode($value, true) : $value;
                echo "{$label1}{$name}: {$close}{$value}" . PHP_EOL;
            }
        }
        // body
        echo "{$label}[BODY]{$close}" . PHP_EOL;
        if ($resource->view) {
            echo $resource->view;
            goto complete;
        }
        $isTraversable = is_array($resource->body) || $resource->body instanceof \Traversable;
        if (!$isTraversable) {
            $resource->body;
            goto complete;
        }
        foreach ($resource->body as $key => $body) {
            if ($body instanceof \BEAR\Resource\Request) {
                switch ($mode) {
                    case self::MODE_REQUEST:
                        $body = "{$label2}" . $body->toUri() . $close;
                        break;
                    case self::MODE_VALUE:
                        $value = $body();
                        $body = var_export($value, true) . " {$label2}" . $body->toUri() . $close;
                        break;
                    case self::MODE_VIEW:
                    default:
                        $body = (string)$body . " {$label2}" . $body->toUri() . $close;
                        break;

                }
            }
            $body = is_array($body) ? var_export($body, true) : $body;
            echo "{$label1}{$key}{$close}:" . $body . PHP_EOL;
        }

        // @codingStandardsIgnoreStart
        complete:
        // @codingStandardsIgnoreEnd

        // links
        echo PHP_EOL;
    }
}
