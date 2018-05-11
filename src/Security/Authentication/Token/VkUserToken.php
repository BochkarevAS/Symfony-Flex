<?php

namespace App\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class VkUserToken extends AbstractToken
{
    protected $key;
    protected $hash;

    public function __construct(array $roles = [])
    {
        parent::__construct($roles);

        // Если пользователь имеет роли, считайте его аутентифицированным
        $this->setAuthenticated(count($roles) > 0);
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function getCredentials()
    {
        return '';
    }
}