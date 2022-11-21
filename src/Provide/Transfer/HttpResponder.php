<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Transfer\TransferInterface;

class HttpResponder implements TransferInterface
{
    public function __construct(
        private HeaderInterface $header,
        private ConditionalResponseInterface $condResponse,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(ResourceObject $ro, array $server): void
    {
        /** @var array{HTTP_IF_NONE_MATCH?: string} $server */
        $isModifed = $this->condResponse->isModified($ro, $server);
        $output = $isModifed ? $this->getOutput($ro, $server) : $this->condResponse->getOutput($ro->headers);

        foreach ($output->headers as $label => $value) {
            // phpcs:ignore SlevomatCodingStandard.Namespaces.ReferenceUsedNamesOnly.ReferenceViaFallbackGlobalName
            header("{$label}: {$value}", false);
        }

        // phpcs:ignore SlevomatCodingStandard.Namespaces.ReferenceUsedNamesOnly.ReferenceViaFallbackGlobalName
        http_response_code($output->code);

        echo $output->view;
    }

    /** @param array<string, string> $server */
    private function getOutput(ResourceObject $ro, array $server): Output
    {
        $ro->toString(); // render and set headers

        return new Output($ro->code, ($this->header)($ro, $server), $ro->view ?: $ro->toString());
    }
}
