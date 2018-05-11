<?php

namespace App\Security\Authentication\Provider;

use App\Security\Authentication\Token\VkUserToken;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class VkProvider implements AuthenticationProviderInterface
{
    private $userProvider;
    private $cachePool;

    public function __construct(UserProviderInterface $userProvider, CacheItemPoolInterface $cachePool)
    {
        $this->userProvider = $userProvider;
        $this->cachePool = $cachePool;
    }

    public function authenticate(TokenInterface $token)
    {
        $user = $this->userProvider->loadUserByUsername($token->getUsername());

        if ($user /* && $this->validateDigest($token->digest, $token->nonce, $token->created, $user->getPassword())*/) {
            $authenticatedToken = new VkUserToken($user->getRoles());
            $authenticatedToken->setUser($user);

            return $authenticatedToken;
        }

        throw new AuthenticationException('The WSSE authentication failed.');

//        $token->setAuthenticated(false);
//
//        throw new AuthenticationException('The WSSE authentication failed.');
//
//        dump(2);
//        die;
//        $user = $this->userProvider->loadUserByUsername($token->getUsername());
//
//        if ($user && $this->validateDigest($token->digest, $token->nonce, $token->created, $user->getPassword())) {
//            $authenticatedToken = new WsseUserToken($user->getRoles());
//            $authenticatedToken->setUser($user);
//
//            return $authenticatedToken;
//        }
//
//        throw new AuthenticationException('The WSSE authentication failed.');
    }

    public function supports(TokenInterface $token)
    {
        // TODO: Implement supports() method.
    }
}