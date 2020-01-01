<?php
require "vendor/autoload.php";
require 'vendor/yiisoft/yii2/Yii.php';

$token = 'c2e71148c8d8b67499ea70fa0e84f6ee96587636753daf03f554aeb9e75ff7ed';
$secret = 'SECf72b52f4a509e3c593503a09637fdd259bc836bba27739488ad305443a4fab38';

//$robot = Yii::createObject([
//    'class' => \yii\dingtalk\Robot::class,
//    'token' => $token,
//    'secret' => $secret
//]);

$app = new \yii\console\Application([
    'id' => 'a',
    'basePath' => dirname(__DIR__),
    'components' => [
        'robot' => [
            'class' => \yii\dingtalk\Robot::class,
            'token' => $token,
            'secret' => $secret
        ]
    ],
    'params' => [
        'ha' => 'aa',
        'cc' => [
            'dd' => '123'
        ]
    ]
]);
dd(config('cc.dd'));



//$target = Yii::createObject([
//    'class' => \yii\dingtalk\Target::class,
//    'robot' => 'robot'
//]);
//
//var_dump($target->export());