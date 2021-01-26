<?php


namespace yii2\ding;


use GuzzleHttp\Client;
use yii\base\Component;
use yii\helpers\Json;

class Robot extends Component
{
    private $baseUri = "https://oapi.dingtalk.com";

    public $token;

    public $secret;

    /**
     * @var Client
     */
    private $client = null;

    public function init()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri
        ]);
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function sendText($atMobiles = [], $isAtAll = false)
    {
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $this->text
            ],
            'at' => [
                'atMobiles' => $atMobiles,
                'isAtAll' => $isAtAll
            ]
        ];

        return $this->send($data);
    }

    public function sendLink($url, $picUrl = '')
    {
        $data = [
            'msgtype' => 'link',
            'link' => [
                'title' => $this->title,
                'text' => $this->text,
                'messageUrl' => $url,
                'picUrl' => $picUrl
            ]
        ];

        return $this->send($data);
    }

    public function sendMarkdown($atMobiles = [], $isAtAll = false)
    {
        $data = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $this->title,
                'text' => $this->text,
                'atMobiles' => $atMobiles,
                'isAtAll' => $isAtAll
            ]
        ];

        return $this->send($data);
    }

    public function sendActionCard($singleTitle, $singleURL)
    {
        $data = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $this->title,
                'text' => $this->text,
                'singleTitle' => $singleTitle,
                'singleURL' => $singleURL
            ]
        ];

        return $this->send($data);
    }

    public function sendActionCardSheet($buttons, $btnOrientation = 0, $hideAvatar = 0)
    {
        $ops = [];

        foreach ($buttons as $button) {
            array_push($ops, [
                'title' => $button['name'],
                'actionURL' => $button['url']
            ]);
        }

        $data = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $this->title,
                'text' => $this->text,
                'btns' => $ops
            ]
        ];

        return $this->send($data);
    }

    private function send($message)
    {
        $timestamp = round(microtime(true) * 1000);

        try {
            $response = $this->client->post('/robot/send', [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'query' => [
                    'access_token' => $this->token,
                    'timestamp' => $timestamp,
                    'sign' => $this->genSign($timestamp)
                ],
                'body' => Json::encode($message)
            ]);

            $content = $response->getBody()->getContents();

            $content = Json::decode($content);

            return $content['errcode'] == 0;
        } catch (\Exception $exception) {
            \Yii::error($exception->getMessage());
        }

        return false;
    }

    private function genSign($timestamp)
    {
        $data = sprintf("%s\n%s", $timestamp, $this->secret);

        return base64_encode(hash_hmac('sha256', $data, $this->secret, true));
    }

    private $title;

    public function setTitle($value)
    {
        $this->title = $value;
        return $this;
    }

    private $text;

    public function setText($value)
    {
        $this->text = $value;
        return $this;
    }
}
