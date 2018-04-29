<?php

namespace App\Service\API\VK;

class VkUserService implements VkUserInterface
{

    public function getUser($id) {
        $params = [
            'user_id' => $id,
            'v' => '5.52'
        ];

        $url = 'https://api.vk.com/method/users.get?' . http_build_query($params);
        $result = json_decode(file_get_contents($url), true);

        return $result['response'][0];
    }

    public function getUserFollowers($id) {
        $fields = [
            'first_name', 'last_name'
        ];

        $params = [
            'user_id' => $id,
            'fields' => $fields,
            'v' => '5.52'
        ];

        $url = 'https://api.vk.com/method/users.getFollowers?' . http_build_query($params);
        $result = json_decode(file_get_contents($url), true);

        return $result['response'];
    }

    public function getUserFriends($id) {
        $fields = [
            'nickname'
        ];

        $params = [
            'user_id' => $id,
            'fields' => $fields,
            'v' => '5.52'
        ];

        $url = 'https://api.vk.com/method/friends.get?' . http_build_query($params);
        $result = json_decode(file_get_contents($url), true);

        return $result['response'];
    }
}