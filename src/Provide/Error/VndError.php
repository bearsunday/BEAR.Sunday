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
use BEAR\Resource\Exception\ServerErrorException;
use BEAR\Sunday\Extension\Error\ErrorInterface;
use BEAR\Sunday\Extension\Router\RouterMatch as Request;

/**
 * vnd.error for BEAR.Package
 *
 * @see https://github.com/blongden/vnd.error
 */
class VndError implements ErrorInterface
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    const HEADER = 'Content-Type: application/vnd.error+json';

    /**
     * @var array
     */
    private $body = [];

    /**
     * {@inheritdoc}
     */
    public function handle(\Exception $e, Request $request)
    {
        $isCodeError = ($e instanceof NotFound || $e instanceof BadRequest || $e instanceof ServerErrorException);
        if ($isCodeError) {
            $this->code = $e->getCode();
            $this->body = ['message' => (new Code)->statusText[$this->code]];

            return $this;
        }
        $this->code = 500;
        $this->body = ['message' => '500 Server Error'];
        error_log($request);
        error_log($e);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function transfer()
    {
        http_response_code($this->code);
        header(self::HEADER);
        echo json_encode($this->body);
    }
}

