<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$request = new \mipotech\doxi\requests\GetDocumentWithSigns(
    getenv('DOXI_BASE_ENDPOINT'),
    getenv('DOXI_USERNAME'),
    getenv('DOXI_PASSWORD')
);
$request->signFlowId = 'aa0d7994-3411-40c8-93d0-a18cdc0882d9';
$request->debug = 1;
$res = $request->execute();
if (!empty($res)) {
    file_put_contents(__DIR__ . '/output.pdf', $res);
}
