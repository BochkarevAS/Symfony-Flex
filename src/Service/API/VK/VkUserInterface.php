<?php

namespace App\Service\API\VK;

interface VkUserInterface
{
    public function getUser($id);

    public function getFollowers($id);

    public function getFriends($id);

    public function setStatus($token);
}