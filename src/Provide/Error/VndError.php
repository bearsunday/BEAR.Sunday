<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Error;

use BEAR\Resource\Code;
use BEAR\Resource\Exception\BadRequestException as BadRequest;
use BEAR\Resource\Exception\ResourceNotFoundException as NotFound;
use BEAR\Resource\Exception\ServerErrorException as ServerError;
use BEAR\Sunday\Extension\Error\ErrorInterface;
use BEAR\Sunday\Extension\Router\RouterMatch as Request;
use BEAR\Sunday\Extension\Transfer\TransferInterface;
use Exception;

use function array_key_exists;
use function error_log;

/**
 * Vnd.Error media type error
 *
 * @see https://github.com/blongden/vnd.error
 */
final class VndError implements ErrorInterface
{
    private const CONTENT_TYPE = 'application/vnd.error+json';

    /** @var array{Content-Type: string} */
    public $headers = ['Content-Type' => ''];

    /** @var array{message: string} */
    public $body = ['message' => ''];
    private ErrorPage $errorPage;

    public function __construct(
        private TransferInterface $transfer,
    ) {
        $this->errorPage = new ErrorPage();
    }

    /**
     * {@inheritdoc}
     *
     * @noinspection ForgottenDebugOutputInspection
     */
    public function handle(Exception $e, Request $request) // phpcs:disable SlevomatCodingStandard.Exceptions.ReferenceThrowableOnly.ReferencedGeneralException
    {
        if ($this->isCodeExists($e)) {
            $this->errorPage->code = (int) $e->getCode();
            $this->errorPage->body = ['message' => (new Code())->statusText[$this->errorPage->code]];

            return $this;
        }

        $this->errorPage->code = 500;
        $this->errorPage->body = ['message' => '500 Server Error'];
        error_log((string) $request);
        error_log((string) $e);

        return $this;
    }

    public function transfer(): void
    {
        $this->errorPage->headers['Content-Type'] = self::CONTENT_TYPE;
        $this->transfer->__invoke($this->errorPage, []);
    }

    private function isCodeExists(Exception $e): bool
    {
        if (! ($e instanceof NotFound) && ! ($e instanceof BadRequest) && ! ($e instanceof ServerError)) {
            return false;
        }

        return array_key_exists($e->getCode(), (new Code())->statusText);
    }
}
