<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Provide\Error;

use BEAR\Resource\Code;
use BEAR\Resource\Exception\BadRequestException as BadRequest;
use BEAR\Resource\Exception\ResourceNotFoundException as NotFound;
use BEAR\Resource\Exception\ServerErrorException as ServerError;
use BEAR\Resource\Exception\ServerErrorException;
use BEAR\Sunday\Extension\Error\ErrorInterface;
use BEAR\Sunday\Extension\Router\RouterMatch as Request;

/**
 * vnd.error
 *
 * @see https://github.com/blongden/vnd.error
 */
class VndError implements ErrorInterface
{
    /**
     * @var ErrorPage
     */
    private $error;

    public function __construct()
    {
        $this->error = new ErrorPage;
        $this->error->headers['Content-Type'] = 'application/vnd.error+json';
        $this->error->headers = [];
    }

    /**
     * {@inheritdoc}
     */
    public function handle(\Exception $e, Request $request)
    {
        if ($e instanceof NotFound || $e instanceof BadRequest) {
            return $this->codeError($e);
        }
        return $this->serverError($e, $request);
    }

    private function codeError(\Exception $e)
    {
        $code = $e->getCode();
        $this->error->code = $code;
        $message =  $code . ' ' . (new Code)->statusText[$code];
        $this->error->body = ['message' => $message];

        return $this->error;
    }

    /**
     * @param \Exception $e
     * @param Request    $request
     */
    private function serverError(\Exception $e, Request $request)
    {
        if ($e instanceof ServerErrorException) {
            return $this->codeError($e);
        }
        $this->error->code = 500;
        $this->error->body = ['message' => '500 Server Error'];
        error_log((string) $request);
        error_log($e);

        return $this->error;
    }
}
