<?php

defined('CONFIG_FILE') or define('CONFIG_FILE', __DIR__ . '/' . '.env');

require "vendor/autoload.php";
require 'vendor/yiisoft/yii2/Yii.php';

var_dump(config('db.name'));