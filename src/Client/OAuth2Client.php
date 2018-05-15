<?php

namespace App\Client;

use App\Client\Provider\AbstractProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class OAuth2Client
{
    private $requestStack;
    private $provider;

    public function __construct(AbstractProvider $provider, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->provider = $provider;
    }

    public function redirect()
    {
        $token = $this->getSession()->get('token');
        $url = $this->provider->getAuthorizationUrl();

        if ($token) {
            return new RedirectResponse('vk/main.html.twig');
        }

        return new RedirectResponse($url);
    }

    public function getAccessToken()
    {
        $code = $this->getCurrentRequest()->get('code');

        if (!$code) {
            throw new \LogicException('No "code" parameter was found (usually this is a query parameter)!');
        }

        $contents = $this->provider->getContents($code);
        $this->getSession()->set('token', $contents['access_token']);

        return $contents;
    }

    private function getCurrentRequest()
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            throw new \LogicException('There is no "current request", and it is needed to perform this action');
        }

        return $request;
    }

    private function getSession()
    {
        $session = $this->getCurrentRequest()->getSession();

        if (!$session) {
            throw new \LogicException('In order to use "state", you must have a session. Set the OAuth2Client to stateless to avoid state');
        }

        return $session;
    }
}