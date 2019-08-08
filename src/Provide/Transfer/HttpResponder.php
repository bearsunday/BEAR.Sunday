<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Transfer\TransferInterface;

class HttpResponder implements TransferInterface
{
    /**
     * @var HeaderInterface
     */
    private $header;

    /**
     * @var ConditionalResponseInterface
     */
    private $condResponse;

    public function __construct(HeaderInterface $header, ConditionalResponseInterface $condResponse)
    {
        $this->header = $header;
        $this->condResponse = $condResponse;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(ResourceObject $ro, array $server)
    {
        $isModifed = $this->condResponse->isModified($ro, $server);
        $output = $isModifed ? $this->getOutput($ro, $server) : $this->condResponse->getOutput($ro->headers);

        // header
        foreach ($output->headers as $label => $value) {
            header("{$label}: {$value}", false);
        }

        // code
        http_response_code($output->code);

        // body
        echo $output->view;
    }

    private function getOutput(ResourceObject $ro, array $server) : Output
    {
        $ro->toString(); // render and set headers
        return new Output($ro->code, ($this->header)($ro, $server), $ro->view ?: $ro->toString());
    }
}
