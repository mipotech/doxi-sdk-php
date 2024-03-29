<?php

namespace mipotech\doxi\requests;

class GetFlowsStatus extends BaseRequest
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
        return 'GetFlowsStatus';
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): string
    {
        return 'POST';
    }
}
