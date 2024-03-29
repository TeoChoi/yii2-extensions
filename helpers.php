<?php

use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use yii\web\Response;
use yii2\ding\Robot;

if (defined('RDC_CONFIG_PATH')) {
    (new Dotenv(RDC_CONFIG_PATH))->load();
}

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

if (!function_exists('config')) {
    function config($key = null, $default = null)
    {
        return \Tightenco\Collect\Support\Arr::get(Yii::$app->params, $key, $default);
    }
}

if (!function_exists('http')) {
    function http($baseUri, $options = [])
    {
        return new \yii2\http\HttpClient($baseUri, $options);
    }
}

if (!function_exists('validator')) {
    function validator(array $data, array $rules = [], array $message = [])
    {
        return new \yii2\validation\Validator($data, $rules, $message);
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
        return response_json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}

if (!function_exists('response_json')) {
    /**
     * @param $code
     * @param $message
     * @param null $data
     * @return \yii\console\Response|Response
     */
    function response_json($anyData)
    {
        $response = \Yii::$app->getResponse();
        $response->format = Response::FORMAT_JSON;

        $response->data = $anyData;

        return $response;
    }
}

if (!function_exists('device')) {
    /**
     * @return \Detection\MobileDetect
     */
    function device()
    {
        return new \Detection\MobileDetect();
    }
}

if (!function_exists('request')) {

    /**
     * @return \yii\console\Request|\yii\web\Request
     */
    function request()
    {
        return Yii::$app->request;
    }
}

if (!function_exists('logger')) {
    /**
     * @param null $message
     * @param array $context
     * @return \Monolog\Logger|void
     */
    function logger($message = null, array $context =[])
    {
        $key = 'logger';

        try {
            if (Yii::$app->has($key) != false) {
                /* @var $logger \Monolog\Logger*/
                $logger = Yii::$app->get($key, false);
            } else {
                $logger = new \Monolog\Logger('application');
                $handler = new StreamHandler(\Yii::$app->runtimePath . '/logs/app-' . date('Y-m-d') . '.log');
                $logger = $logger->pushHandler($handler);
                Yii::$app->set($key, $logger);
            }

            if ($message != null) {
                $logger->info($message, $context);
            }

            return $logger;
        } catch (Exception $exception) {
            Yii::error($exception->getMessage());
        }
    }
}

if (!function_exists('logger_exception')) {
    function logger_exception($message, \Exception $exception)
    {
        logger()->error($message, [
            'post' => request()->post(),
            'get' => request()->get(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),
        ]);
    }
}

if (!function_exists('ding')) {

    /**
     * @param $dingName
     * @return Robot
     * @throws \yii\base\InvalidConfigException
     */
    function ding($dingName)
    {
        $component = Yii::$app->get($dingName, false);
        if ($component instanceof Robot) {
            return $component;
        }
        return null;
    }
}

if (!function_exists('redis')) {
    /**
     * @param string $id
     * @return \yii\redis\Connection|null
     * @throws
     */
    function redis($id='redis') {
        $connect = Yii::$app->get($id, false);
        if ($connect instanceof \yii\redis\Connection) {
            return $connect;
        }
        return null;
    }
}

if (!function_exists('db')) {
    /**
     * @param string $id
     * @return \yii\db\Connection|null
     * @throws
     */
    function db($id='db') {
        $connect = Yii::$app->get($id, false);
        if ($connect instanceof \yii\db\Connection) {
            return $connect;
        }
        return null;
    }
}
