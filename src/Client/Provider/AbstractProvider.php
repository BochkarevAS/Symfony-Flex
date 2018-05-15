<?php

namespace App\Client\Provider;

abstract class AbstractProvider
{
    abstract protected function getAuthorizationCode();

    abstract public function getContents($code);

    public function getAuthorizationUrl()
    {
        return $this->getAuthorizationCode();
    }
}