<?php

namespace mipotech\doxi\requests;

class GetUserTemplates extends BaseRequest
{
    /**
     * @inheritdoc
     */
    public function getEndpoint(): string
    {
        return 'GetUserTemplates';
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): string
    {
        return 'GET';
    }
}
