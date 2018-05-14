<?php

namespace App\Client;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class OAuth2Client
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function redirect()
    {
        $scope = [
            'notify', 'friends', 'photos', 'audio', 'video', 'stories', 'pages',
            'status', 'notes', 'wall', 'ads', 'offline', 'docs', 'groups',
            'notifications', 'stats', 'email', 'market'
        ];

        $http = [
            'client_id'     => '6453345',
            'redirect_uri'  => 'http://127.0.0.1:8000/api',
            'display'       => 'page',
            'response_type' => 'code',
            'scope'         => implode(',', $scope)
        ];

        $url = "https://oauth.vk.com/authorize?" . http_build_query($http);

        return new RedirectResponse($url);
    }

    public function getAccessToken(Response $response)
    {
        $code = $this->getCurrentRequest()->get('code');

        dump($code);
        die;

        if (!$code) {
            throw new \LogicException('No "code" parameter was found (usually this is a query parameter)!');
        }

//        return $this->provider->getAccessToken('authorization_code', [
//            'code' => $code,
//        ]);
    }

    private function getCurrentRequest()
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            throw new \LogicException('There is no "current request", and it is needed to perform this action');
        }

        return $request;
    }

}