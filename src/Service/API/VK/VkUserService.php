<?php

namespace App\Service\API\VK;

use Psr\Cache\CacheItemPoolInterface;

class VkUserService extends VkCacheService implements VkUserInterface
{
    private $version = '5.52';

    public function __construct(CacheItemPoolInterface $cache)
    {
        parent::__construct($cache);
    }

    public function getUser($id)
    {
        $params = [
            'user_id' => $id,
            'v' => $this->version
        ];

        $url = 'https://api.vk.com/method/users.get?' . http_build_query($params);
        $result = json_decode(file_get_contents($url), true);

        return $result['response'][0];
    }

    public function setStatus($token)
    {
        $status = file($_SERVER['DOCUMENT_ROOT'] . '/status.txt');

        $params = [
            'text'  => $status[mt_rand(0, 19)],
            'access_token' => $token,
            'v'     => $this->version
        ];

        $url = 'https://api.vk.com/method/status.set?' . http_build_query($params);
        $result = json_decode(file_get_contents($url), true);

        return $result['response'];
    }

    public function getFollowers($id)
    {
        $fields = [
            'first_name', 'last_name', 'photo_50'
        ];

        $params = [
            'user_id' => $id,
            'fields' => $fields,
            'v' => $this->version
        ];

        $url = 'https://api.vk.com/method/users.getFollowers?' . http_build_query($params);
        $result = json_decode(file_get_contents($url), true);
        $data = $this->cacheFollowers($result['response']);

        return $data;
    }

    public function getFriends($id)
    {
        $fields = [
            'nicknam', 'photo_50'
        ];

        $params = [
            'user_id' => $id,
            'fields' => $fields,
            'v' => $this->version
        ];

        $url = 'https://api.vk.com/method/friends.get?' . http_build_query($params);
        $result = json_decode(file_get_contents($url), true);
        $data = $this->cacheFriends($result['response']);

        return $data;
    }
}