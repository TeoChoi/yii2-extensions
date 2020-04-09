<?php

namespace yii2\http;

use GuzzleHttp\Client;
use yii\helpers\Json;

class HttpClient
{
    private $client = null;

    private $baseUri = null;

    public function __construct($baseUri)
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri = $baseUri,
            'timeout' => 5
        ]);
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
            $response = $this->client->post($url, [
                'headers' => $headers,
                'form_params' => $data
            ]);

            $content = $response->getBody()->getContents();

            $result = Json::decode($content);

            logger("$uId 请求结果:", (array)$result);

            return $result;
        } catch (\Exception $exception) {
            \Yii::error(implode('|', [$this->baseUri, $url, $data, $exception->getMessage()]));
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
            $response = $this->client->post($url, [
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