<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$request = new \mipotech\doxi\requests\AddSignFlow(getenv('DOXI_USERNAME'), getenv('DOXI_PASSWORD'));
$request->debug = 1;
$request->documentFileName = '';
$request->senderUserName = 'jonnys';
$request->description = 'My first test file';
/**
 * @var array each element should be in the following format:
 *
 * - userEmail (string)
 * - elementType (int)
 * - elementSubType (int)
 * - pageNumber (int)
 * - position (array)
 *     - top (int)
 *     - left (int)
 *     - width (int)
 *     - height (int)
 * - isEditorElement (bool)
 * - textSize (int)
 * - isRequired (bool)
 * - validations (array)
 * - dropDownList (array)
 * - additionalInfo (array)
 */
$request->flowElements = [
    [
        'userEmail' => 'chaim@mipo.co.il',
        'elementType' => 0,
        //'elementSubType' => ,
        'pageNumber' => 1,
        'position' => [
            'top' => 600,
            'left' => 400,
            'width' => 100,
            'height' => 40,
        ],
    ],
];
$request->sendMethodType = 0;
$request->isSendApprovalMailToAllSigners = true;
$request->isAutomaticRemainder = true;
$request->dayesForAutomaticRemainder = 2;
$request->customFields = [
    [],
];
$request->users = [
    [],
];
$request->packageId = '';
$request->packageName = '';
$request->isNoSend = false;
$request->preliminaryText = '';
$request->base64DocumentFile = chunk_split(base64_encode(file_get_contents(__DIR__ . '/file.pdf')));
$res = $request->execute();
var_dump($res);
