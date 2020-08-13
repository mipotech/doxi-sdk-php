<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$request = new \mipotech\doxi\requests\GetDocumentWithSigns(getenv('DOXI_USERNAME'), getenv('DOXI_PASSWORD'));
$request->signFlowId = 'xxxx';
$res = $request->execute();
var_dump($res);
