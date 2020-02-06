<?php
namespace App\Utility;

use GuzzleHttp\Client;

class ApiClient
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function post($url, array $data = [], $type = 'json')
    {
        return $this->request('post', $url, $data, $type);
    }

    public function get($url, array $data = [])
    {
        return $this->request('GET', $url, $data);
    }

    public function request($method, $url, array $data = [])
    {
        $accessToken = $this->getUserAccessToken();

        $all = [];
        if (count($data)) {
            $all['json'] = $data;
        }

        if ($accessToken) {
            $all['headers']['Authorization'] = 'Bearer '.$accessToken;
        }

        try {
            $response = $this->client->request($method, $url, $all);
        } catch (\Exception $e) {
            $response = $e->getResponse();
        }

        return $this->response_handler($response->getStatusCode(), $response->getBody()->getContents());
    }

    public function response_handler($statusCode, $response)
    {
        if ($response) {
            $data = json_decode($response,true);

            $data['status'] = $statusCode;

            return $data;
        }

        return [];
    }

    private function getUserAccessToken()
    {
        $token = session('token');

        if (!$token) {
            return null;
        }

        return $token;
    }
}
