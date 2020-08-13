<?php

namespace mipotech\doxi\requests;

class GetFlowMetadata extends BaseRequest
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
        return 'GetFlowMetadata';
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): string
    {
        return 'GET';
    }
}
