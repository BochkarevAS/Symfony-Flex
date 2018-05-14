<?php

namespace App\Security\Firewall;

use App\Client\OAuth2Client;
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

        $client = new OAuth2Client($requestStack);
        $response = $client->redirect();

        dump($response);
        die;


//        dump($requestStack->getCurrentRequest());


        $client->getAccessToken();


        dump($client);
        die;

//        $wsseRegex = '/UsernameToken Username="([^"]+)", PasswordDigest="([^"]+)", Nonce="([a-zA-Z0-9+\/]+={0,2})", Created="([^"]+)"/';
//        if (!$request->headers->has('x-wsse') || 1 !== preg_match($wsseRegex, $request->headers->get('x-wsse'), $matches)) {
//            return;
//        }







//        throw new AuthenticationException('The WSSE authentication failed.');
//
//
//
//        if (!$request->headers->has('Authorization')) {
//            return;
//        }

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