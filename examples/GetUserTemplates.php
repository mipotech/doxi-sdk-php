<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$request = new \mipotech\doxi\requests\GetUserTemplates(
    getenv('DOXI_BASE_ENDPOINT'),
    getenv('DOXI_USERNAME'),
    getenv('DOXI_PASSWORD')
);
$request->debug = 1;
$res = $request->execute();
var_dump($res);
