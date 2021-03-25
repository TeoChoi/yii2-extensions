<?php


namespace yii2\ding;

use yii\base\InvalidRouteException;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class Target extends \yii\log\Target
{
    /**
     * @var Robot
     */
    public $robot;

    public $token;
    public $secret;

    public $logVars = [
        '_COOKIE',
        '_GET',
        '_POST',
        '_FILES',
        '_SERVER.REQUEST_METHOD',
        '_SERVER.REQUEST_URI',
        '_SERVER.HTTP_USER_AGENT',
        '_SERVER.HTTP_HOST',
        '_SERVER.HTTP_X_ORIGINAL_URI',
    ];

    public function init()
    {
        parent::init();
        if (!empty($this->robot)) {
            $this->robot = Instance::ensure($this->robot);
        }

        if (empty($this->robot) && !empty($this->token) && !empty($this->secret)) {
            $this->robot = \Yii::createObject([
                'class' => Robot::class,
                'token' => $this->token,
                'secret' => $this->secret
            ]);
        }

        if (empty($this->robot)) {
            throw new \Exception('确实参数: robot或token和secret');
        }
    }

    public function export()
    {
        $messages = array_map([$this, 'formatMessage'], $this->messages);

        $title = "【". env('app.env'). "】" . \Yii::$app->id;

        $body = implode(PHP_EOL . '>', explode(PHP_EOL, implode(PHP_EOL, $messages)));

        $body = sprintf("#### %s \r\n > %s", $title, $body);

        $this->robot->setTitle($title)->setText($body)->sendMarkdown();
    }
}
