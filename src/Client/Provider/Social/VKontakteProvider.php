<?php

namespace App\Client\Provider\Social;

use App\Client\Provider\AbstractProvider;
use GuzzleHttp\Client;

class VKontakteProvider extends AbstractProvider
{
    protected function getAuthorizationCode()
    {
        $scope = [
            'notify', 'friends', 'photos', 'audio', 'video', 'stories', 'pages',
            'status', 'notes', 'wall', 'ads', 'offline', 'docs', 'groups',
            'notifications', 'stats', 'email', 'market'
        ];

        $options = [
            'client_id'     => '6453345',
            'redirect_uri'  => 'http://127.0.0.1:8000/api',
            'display'       => 'page',
            'response_type' => 'code',
            'scope'         => implode(',', $scope)
        ];

        return "https://oauth.vk.com/authorize?" . http_build_query($options);
    }

    public function getContents($code)
    {
        $client = new Client([
            'base_uri' => 'https://oauth.vk.com',
            'timeout' => 10
        ]);

        $response = $client->request('POST', '/access_token', [
            'form_params' => [
                'client_id'     => '6453345',
                'client_secret' => 'kKI7eT4hIQRNL3i0VV3X',
                'redirect_uri'  => 'http://127.0.0.1:8000/api',
                'code'          => $code
            ]
        ]);

        $contents = $response->getBody()->getContents();

        return json_decode($contents, true);
    }
}