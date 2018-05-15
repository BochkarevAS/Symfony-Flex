<?php

namespace App\Security\Firewall;

use App\Client\OAuth2Client;
use App\Client\Provider\Social\VKontakteProvider;
use App\Security\Authentication\Token\VkUserToken;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
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

//        dump($contents);
//        die;

        if (($token = $contents['access_token']) && ($uid = $contents['user_id']) && ($email = $contents['email'])) {
            $vkUserToken = new VkUserToken();
            $vkUserToken->setKey($uid);
            $vkUserToken->setHash($token);
            $vkUserToken->setEmail($email);

        }


    }
}