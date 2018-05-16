<?php

namespace App\Security\Firewall;

use App\Client\OAuth2Client;
use App\Client\Provider\Social\VKontakteProvider;
use App\Security\Authentication\Token\VkUserToken;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

class VkListener implements ListenerInterface
{
    protected $tokenStorage;
    protected $authenticationManager;

    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }

    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $requestStack = new RequestStack();
        $requestStack->push($request);

        $client = new OAuth2Client(new VKontakteProvider(), $requestStack);
        $contents = $client->getAccessToken();

        if (($hash = $contents['access_token']) && ($uid = $contents['user_id']) && ($email = $contents['email'])) {
            $token = new VkUserToken();
            $token->setUser("vk{$uid}");
            $token->setKey($uid);
            $token->setHash($hash);
            $token->setEmail($email);

            try {
                $authToken = $this->authenticationManager->authenticate($token);
                $this->tokenStorage->setToken($authToken);
            } catch (AuthenticationException $failed) {
                $failedMessage = 'Login failed for '.$token->getUsername() . '. Why ? ' . $failed->getMessage();
                $response = new Response();
                $response->setStatusCode(403);
                $response->setContent($failedMessage);
                $event->setResponse($response);

                return $response;
            }
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_FORBIDDEN);
        $event->setResponse($response);

        return $response;
    }
}