<?php

if (! function_exists('config')) {
    function config($name, $default = null)
    {
        return \yii\dotenv\Config::get($name, $default);
    }
}
