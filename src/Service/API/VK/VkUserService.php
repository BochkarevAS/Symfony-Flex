<?php

namespace App\Service\API\VK;

use Psr\Cache\CacheItemPoolInterface;

class VkUserService extends VkCacheService implements VkUserInterface
{
    const VERSION = '5.52';

    private $token;

    public function __construct(CacheItemPoolInterface $cache)
    {
        parent::__construct($cache);
    }

    public function getUser($id, $token)
    {
        $params = [
            'user_id'      => $id,
            'access_token' => $token,
            'v'            => self::VERSION
        ];

        $url = 'https://api.vk.com/method/users.get?' . http_build_query($params);
        $result = json_decode(file_get_contents($url), true);

        return $result['response'][0];
    }

    public function setStatus()
    {
        $status = file($_SERVER['DOCUMENT_ROOT'] . '/status.txt');

        $params = [
            'text'  => $status[mt_rand(0, 19)],
            'v'     => self::VERSION
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
            'user_id'      => $id,
            'fields'       => $fields,
            'access_token' => $this->token,
            'v'            => self::VERSION
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
            'user_id'      => $id,
            'fields'       => $fields,
            'access_token' => $this->token,
            'v'            => self::VERSION
        ];

        $url = 'https://api.vk.com/method/friends.get?' . http_build_query($params);
        $result = json_decode(file_get_contents($url), true);

        dump($this->token);
        die;

        $data = $this->cacheFriends($result['response']);

        return $data;
    }
}