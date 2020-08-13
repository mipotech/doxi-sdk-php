<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$request = new \mipotech\doxi\requests\AddSignFlow(
    getenv('DOXI_BASE_ENDPOINT'),
    getenv('DOXI_USERNAME'),
    getenv('DOXI_PASSWORD')
);
$request->debug = 1;
$request->documentFileName = 'API Example.pdf';
$request->senderUserName = getenv('DOXI_USERNAME');
$request->description = 'Rental agreement 123';
$request->flowElements = [
    [
        'userEmail' => 'chaim@mipo.co.il',
        'elementType' => 0,
        'elementSubType' => 0,
        'pageNumber' => 1,
        'position' => [
            'top' => 735,
            'left' => 43,
            'width' => 230,
            'height' => 40,
        ],
        'isEditorElement' => false,
        'textSize' => 0,
        'isRequired' => true,
        'duplicateElementInfo' => [
            'isAllPagesFromCurrent' => true,
        ],
    ],
];
$request->sendMethodType = 0;
$request->recipients = [
    [
        'email' => 'chaim@mipo.co.il',
        'firstName' => 'John',
        'lastName' => 'Doe',
    ]
];
$request->isSendApprovalMailToAllSigners = true;
$request->isAutomaticRemainder = false;
$request->dayesForAutomaticRemainder = 0;
$request->customFields = [
    [
        'key' => 'SomeInnerSystemIdNumber',
        'value' => '12345',
    ],
];
$request->users = [
    [
        'email' => 'chaim@mipo.co.il',
        'firstName' => 'John',
        'lastName' => 'Doe',
        'smsPhoneNumber' => '0541231234',
        'userPassword' => '0018',
        'isDisableAttachment' => false,
        'isDisplayDownloadDocument' => false,
    ],
];
$request->packageId = 'd583e9e1-3633-420a-aa45-793b4653bac1';
$request->packageName = 'Rental Agreements';
$request->isNoSend = false;
$request->preliminaryText = 'Please sign this form';
$request->base64DocumentFile = base64_encode(file_get_contents(__DIR__ . '/file.pdf'));
$res = $request->execute();
if (!empty($res)) {
    $flowId = $res['SignFlowId'];
    $signerLinks = $res['SignersLink'];
    foreach ($signerLinks as $signerData) {
        $email = $signerData['SignerId'];
        $link = $signerData['Link'];
    }
}
var_dump($res);
