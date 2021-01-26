<?php

namespace yii2\http;

use GuzzleHttp\Client;
use yii\helpers\Json;

class HttpClient
{
    private $client = null;

    private $baseUri = null;

    public function __construct($baseUri, $options = [])
    {
        $options['base_uri'] = $this->baseUri = $baseUri;
        $this->client = new Client($options);
    }

    /**
     * @param $url
     * @param array $data
     * @param array $headers
     * @return bool|mixed
     */
    public function post($url, $data = [], $headers = [])
    {
        $uId = uniqid();
        logger("$uId 请求开始:", collect($data)->push($url)->toArray());
        try {
            $params = ['headers' => $headers];

            switch ($headers['Content-Type']) {
                case "application/x-www-form-urlencoded":
                    $params['form_params'] = $data;
                    break;
                case "multipart/form-data":
                    $params['multipart'] = $data;
                    break;
                default :
                    $params['json'] = $data;
                    break;
            }

            $response = $this->client->post($url, $params);

            $content = $response->getBody()->getContents();

            $result = Json::decode($content);

            logger("$uId 请求结果:", (array)$result);

            return $result;
        } catch (\Exception $exception) {
            \Yii::error($exception->getMessage());
        }
        return false;
    }

    /**
     * @param $url
     * @param array $data
     * @param array $headers
     * @return bool|mixed
     */
    public function get($url, $data = [], $headers = [])
    {
        try {
            $response = $this->client->get($url, [
                'headers' => $headers,
                'query' => $data
            ]);

            $content = $response->getBody()->getContents();

            return Json::decode($content);
        } catch (\Exception $exception) {

        }
        return false;
    }
}
