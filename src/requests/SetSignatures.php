<?php

namespace mipotech\doxi\requests;

class SetSignatures extends BaseRequest
{
  
	public $SignFlowId;
	public $UserCode;
	public $SignerEmail;
	public $DeclineComments;
	public $SignAction;
	public $IsApprove;
	public $SignImageBase64;
	public $BrowserDetails;
	public $IPAddress;
	public $FlowElements;
	public $AttachedFiles;

    /**
     * @inheritdoc
     */
    public function getEndpoint(): string
    {
        return 'SetSignatures';
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): string
    {
        return 'POST';
    }
}
