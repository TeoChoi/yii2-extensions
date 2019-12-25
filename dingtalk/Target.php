<?php


namespace yii2\dingtalk;

use yii\di\Instance;
use yii\helpers\VarDumper;

class Target extends \yii\log\Target
{
    public $id;

    /**
     * @var Robot
     */
    public $robot;

    public $token;
    public $secret;

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

        $body = implode(PHP_EOL, $messages);
        $body = sprintf("【%s】报警 \n %s", $this->id, $body);
        $this->robot->setText($body)->sendText();
    }

    /**
     * @param array $message
     * @return string
     */
    public function formatMessage($message)
    {
        list($text, $level, $category, $timestamp) = $message;

        if (is_string($text) && mb_strlen($text) > 200) {
            // exceptions may not be serializable if in the call stack somewhere is a Closure
            return '';
        }

        if ($text instanceof \Throwable || $text instanceof \Exception) {
            $text = (string)$text;
        } else {
            $text = VarDumper::export($text);
        }

        $prefix = $this->getMessagePrefix($message);
        return $this->getTime($timestamp) . " {$prefix}[$level][$category] $text";
    }
}