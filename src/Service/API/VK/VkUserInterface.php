<?php

namespace App\Service\API\VK;

interface VkUserInterface
{

    public function getUser($id);

    public function getUserFollowers($id);

    public function getUserFriends($id);

}