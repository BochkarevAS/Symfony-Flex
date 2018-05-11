<?php

namespace App\Service\API\VK;

interface VkUserInterface
{
    public function getUser($id, $token);

    public function getFollowers($id);

    public function getFriends($id);

    public function setStatus();
}