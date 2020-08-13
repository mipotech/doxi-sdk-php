<?php

namespace mipotech\doxi\requests;

class GetFlowStatus extends BaseRequest
{
    /**
     * @var string[]
     */
    public $signFlowsIds;

    /**
     * @inheritdoc
     */
    public function getEndpoint(): string
    {
        return 'GetFlowStatus';
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): string
    {
        return 'POST';
    }
}
