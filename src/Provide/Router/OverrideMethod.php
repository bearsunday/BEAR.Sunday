<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Provide\Router;

final class OverrideMethod
{
    /**
     * Request method
     *
     * @var string
     */
    private $method;

    /**
     * HTTP Parameters
     *
     * @var array
     */
    private $query;

    /**
     * Return http method and queries
     *
     * 'queries' will change by method.
     * get method return $_GET, post method return $_POST + $_GET
     * patch | put | delete  return parsed 'php://input' value
     *
     * @param array $server $_SERVER
     * @param array $get    $_GET
     * @param array $post   $_POST
     *
     * @return array
     */
    public function get(array $server, array $get, array $post) {

        // set the original value
        $this->method = strtolower($server['REQUEST_METHOD']);

        // early return on GET
        if ($this->method === 'get') {
            return [$this->method, $get];
        }
        // must be a POST to do an override
        if ($this->method === 'post' && $this->methodOverRide($server, $post)) {
            return [$this->method, $this->query];
        }

        // native method POST / PUT / PATCH / DELETE
        return [$this->method, $this->getParams($this->method, $post)];
    }

    /**
     * HTTP Method override
     *
     * @param array $server
     * @param array $post
     *
     * @return bool is override ?
     */
    private function methodOverRide(array $server, array $post)
    {
        // look for override in post data
        if (isset($post['_method'])) {
            $this->method = strtolower($post['_method']);
            unset($post['_method']);
            $this->query = $post;

            return true;
        }

        // look for override in headers
        if (isset($server['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
            $this->method = strtolower($server['HTTP_X_HTTP_METHOD_OVERRIDE']);
            $this->query = $post;

            return true;
        }

        return false;
    }

    /**
     * Return request parameters
     *
     * @param string $method Request method
     * @param array  $post   $_POST
     *
     * @return array
     */
    private function getParams($method, array $post)
    {
        if ($method === 'put' || $method === 'patch'  || $method === 'delete') {

            return $this->getStdIn();
        }

        return $post;
    }

    /**
     * Return stdin stream data
     * 
     * @return array
     * @see http://php.net/manual/en/features.file-upload.put-method.php
     */
    private function getStdIn()
    {
        $input = file_get_contents('php://input');
        $input ?  parse_str(file_get_contents('php://input'), $stdin) : $stdin = [];

        return $stdin;
    }
}
