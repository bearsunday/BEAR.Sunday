<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Provide\Error;

use BEAR\Resource\Code;
use BEAR\Resource\Exception\BadRequestException as BadRequest;
use BEAR\Resource\Exception\ResourceNotFoundException as NotFound;
use BEAR\Resource\Exception\ServerErrorException as ServerError;
use BEAR\Sunday\Extension\Error\ErrorInterface;
use BEAR\Sunday\Extension\Router\RouterMatch as Request;
use BEAR\Sunday\Extension\Transfer\TransferInterface;

/**
 * Vnd.Error media type error
 *
 * @see https://github.com/blongden/vnd.error
 */
final class VndError implements ErrorInterface
{
    /**
     * @var string
     */
    const CONTENT_TYPE = 'application/vnd.error+json';

    /**
     * @var TransferInterface
     */
    private $transfer;

    /**
     * @var ErrorPage
     */
    private $errorPage;

    public function __construct(TransferInterface $transfer)
    {
        $this->transfer = $transfer;
        $this->errorPage = new ErrorPage;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(\Exception $e, Request $request)
    {
        if ($this->isCodeExists($e)) {
            $this->errorPage->code = $e->getCode();
            $this->errorPage->body = ['message' => (new Code)->statusText[$this->errorPage->code]];

            return $this;
        }
        $this->errorPage->code = 500;
        $this->errorPage->body = ['message' => '500 Server Error'];
        error_log($request);
        error_log($e);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function transfer()
    {
        $this->errorPage->headers['Content-Type'] = self::CONTENT_TYPE;
        $this->transfer->__invoke($this->errorPage, []);
    }

    /**
     * @param \Exception $e
     *
     * @return bool
     */
    private function isCodeExists(\Exception $e)
    {
        if (! ($e instanceof NotFound || $e instanceof BadRequest || $e instanceof ServerError)) {
            return false;
        }

        return array_key_exists($e->getCode(), (new Code)->statusText);
    }

}
