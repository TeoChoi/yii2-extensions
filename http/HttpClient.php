<?php

namespace yii2\http;

use GuzzleHttp\Client;
use yii\helpers\Json;

class HttpClient
{
    private $client = null;

    public function __construct($baseUri)
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
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
        try {
            $response = $this->client->post($url, [
                'headers' => $headers,
                'form_params' => $data
            ]);

            $content = $response->getBody()->getContents();

            return Json::decode($content);
        } catch (\Exception $exception) {

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