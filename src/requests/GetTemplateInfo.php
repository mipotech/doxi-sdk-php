<?php

namespace mipotech\doxi\requests;

class GetTemplateInfo extends BaseRequest
{
    /**
     * @var string
     */
    public $templateId;

    /**
     * @inheritdoc
     */
    public function getEndpoint(): string
    {
        return 'GetTemplateInfo';
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): string
    {
        return 'GET';
    }
}
