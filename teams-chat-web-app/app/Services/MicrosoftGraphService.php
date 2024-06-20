<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class MicrosoftGraphService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getUsers()
    {
        $accessToken = Session::get('access_token');

        $response = $this->client->get('https://graph.microsoft.com/v1.0/users', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}