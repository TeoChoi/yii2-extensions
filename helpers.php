<?php

use Dotenv\Dotenv;
use yii\web\Response;

(new Dotenv(RDC_CONFIG_PATH, 'rdc_security_config.properties'))->load();

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        return $value;
    }
}

if (!function_exists('http')) {
    function http($baseUri)
    {
        return new \yii2\http\HttpClient($baseUri);
    }
}

if (!function_exists('response_ok')) {
    /**
     * @param $message
     * @param null $data
     * @return \yii\console\Response|Response
     */
    function response_ok($message, $data = null)
    {
        return response_send(200, $message, $data);
    }
}

if (!function_exists('response_fail')) {
    /**
     * 错误
     * @param $message
     * @param null $data
     * @return \yii\console\Response|Response
     */
    function response_fail($message, $data = null)
    {
        return response_send(400, $message, $data);
    }
}

if (!function_exists('response_send')) {
    /**
     * @param $code
     * @param $message
     * @param null $data
     * @return \yii\console\Response|Response
     */
    function response_send($code, $message, $data = null)
    {
        $response = \Yii::$app->getResponse();
        $response->format = Response::FORMAT_JSON;

        $response->data = [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];

        return $response;
    }
}