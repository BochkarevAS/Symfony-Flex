<?php

namespace App\Security\Firewall;

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

        dump($request);
        die;

        throw new AuthenticationException('The WSSE authentication failed.');



        if (!$request->headers->has('Authorization')) {
            return;
        }

//        $authorizationHeader = $request->headers->get('Authorization');
//        $tokenString = $this->parseAuthorizationHeader($authorizationHeader);

//        $vkUserToken = new VkUserToken();
//        $user->setFacebookId($userId);
//        $user->setUsername($userInfo['name']);
//        $user->setLang($userInfo['locale']);
//        $user->setEmail($userInfo['email']);
//        $this->entityManager->persist($user);
//        $this->entityManager->flush();




    }
}