<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$request = new \mipotech\doxi\requests\GetAllFlows(
    getenv('DOXI_BASE_ENDPOINT'),
    getenv('DOXI_USERNAME'),
    getenv('DOXI_PASSWORD')
);
$request->debug = 1;
$res = $request->execute();
if (!empty($res)) {
    print_r($res['SignFlowsIds']);
}
