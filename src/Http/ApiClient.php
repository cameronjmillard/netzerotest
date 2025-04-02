<?php

namespace Cammillard\ReqResClient\Http;

use Cammillard\ReqResClient\Exceptions\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://reqres.in/api/',
            'timeout'  => 5.0,
        ]);
    }

    public function get(string $endpoint): array
    {
        try {
            $response = $this->client->get($endpoint);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new ApiException("API request failed: " . $e->getMessage(), 0, $e);
        }
    }

    public function post(string $endpoint, array $data): array
    {
        try {
            $response = $this->client->post($endpoint, [
                'json' => $data
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new ApiException("API request failed: " . $e->getMessage(), 0, $e);
        }
    }
}