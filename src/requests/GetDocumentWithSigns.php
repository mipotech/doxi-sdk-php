<?php

namespace mipotech\doxi\requests;

class GetDocumentWithSigns extends BaseRequest
{
    /**
     * @var string
     */
    public $signFlowId;

    /**
     * @inheritdoc
     */
    public function getEndpoint(): string
    {
        return 'GetDocumentWithSigns';
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): string
    {
        return 'GET';
    }
}
