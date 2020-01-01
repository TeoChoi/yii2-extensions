<?php

//defined('RDC_CONFIG_PATH') or define('RDC_CONFIG_PATH', __DIR__);

require "vendor/autoload.php";
require 'vendor/yiisoft/yii2/Yii.php';

//$baseUri = 'http://api.prod.tmall.me';
//
//$r = http($baseUri)->post('/property/list');
//dd($r);

$data = [
    'blog' => 'github.com/RunnerLee',
];
$rule = [
    'blog' => 'required|url',
];
$validator = validator($data, $rule);

dd($validator->validate(), $validator->fails(), collect($validator->messages())->first());
echo env('aa');
//response_ok('你好');

$device = new \Detection\MobileDetect();

var_dump($device->isMobile());