<?php

namespace mipotech\doxi\requests;

class GetAllFlows extends BaseRequest
{
    /**
     * @inheritdoc
     */
    public function getEndpoint(): string
    {
        return 'GetAllFlows';
    }

    public function getMethod(): string
    {
        return 'GET';
    }
}
