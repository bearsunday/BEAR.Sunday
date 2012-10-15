<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Application;

use BEAR\Resource\Object as ResourceObject;
use BEAR\Resource\Request;
use IteratorIterator;
use Traversable;
use FirePHP;

/**
 * Resource log iterator
 *
 * @package BEAR.Sunday
 */
final class ResourceLogIterator extends IteratorIterator implements Fireable
{
    /**
     * Resource request
     *
     * @var Request
     */
    private $request;

    /**
     * Resource request result
     *
     * @var mixed
     */
    private $result;

    /**
     * Return edited current
     */
    public function current()
    {
        list($this->request, $this->result) = parent::current();

        return $this;
    }

    /**
     * Apc storage log
     *
     * @return void
     */
    public function apcLog()
    {
        $request = $this->request->toUri();
        $result = $this->format($this->result);
        apc_store('request-' . $request, $result);
    }

    /**
     * Format log data
     *
     * @param  array   $body
     *
     * @return unknown
     * @todo scan all prop like print_o, then eliminate all resource/PDO/etc.. unrealisable objects...not like this.
     */
    public function format(&$body)
    {
        if (!(is_array($body) || $body instanceof Traversable)) {
            return $body;
        }
        array_walk_recursive(
            $body,
            function (&$value) {
                if ($value instanceof Request) {
                    $value = '(Request) ' . $value->toUri();
                }
                if ($value instanceof ResourceObject) {
                    $value = '(ResourceObject) ' . get_class($value) . json_encode($value->body);
                }
                if ($value instanceof \PDO || $value instanceof \PDOStatement) {
                    $value = '(PDO) ' . get_class($value);
                }
                if ($value instanceof \Doctrine\DBAL\Connection) {
                    $value = '(\Doctrine\DBAL\Connection) ' . get_class($value);
                }
                if (is_resource($value)) {
                    $value = '(resource) ' . gettype($value);
                }
                if (is_object($value)) {
                    $value = '(object) ' . get_class($value);
                }
            }
        );

        return $body;
    }

    /**
     * Fire - output firebug console
     *
     * @return void
     */
    public function fire()
    {
        $this->firePhp = FirePHP::getInstance(true);
        $requestLabel = $this->request->toUriWithMethod();
        $this->firePhp->group($requestLabel);
        if ($this->result instanceof ResourceObject) {
            $this->fireResourceObjectLog();
        } else {
            $this->firePhp->log($this->result);
        }
        $this->firePhp->groupEnd();

        return;
    }

    /**
     * Fire resource object log
     *
     * @return void
     */
    private function fireResourceObjectLog()
    {
        // code
        $this->firePhp->log($this->result->code, 'code');

        // headers
        $headers = [];
        $headers[] = ['name', 'value'];
        foreach ($this->result->headers as $name => $value) {
            $headers[] = [$name, $value];
        }
        $this->firePhp->table('headers', $headers);

        // body
        $body = $this->format($this->result->body);
        $isTable = is_array($body)
            && isset($body[0])
            && isset($body[1])
            && (array_keys($body[0]) === array_keys($body[1]));
        if ($isTable) {
            $table = [];
            $table[] = (array_values(array_keys($body[0])));
            foreach ((array)$body as $val) {
                $table[] = array_values((array)$val);
            }
            $this->firePhp->table('body', $table);
        } else {
            $this->firePhp->log($body, 'body');
        }

        // links
        $links = [['rel', 'uri']];
        foreach ($this->result->links as $rel => $uri) {
            $links[] = [$rel, $uri];
        }
        if (count($links) > 1) {
            $this->firePhp->table('links', $links);
        }
        $this->firePhp->group('view', ['Collapsed' => true]);
        $this->firePhp->log($this->result->view);
        $this->firePhp->groupEnd();
    }
}
