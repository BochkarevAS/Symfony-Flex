<?php

namespace App\Service\API\VK;

class VkUserService implements VkUserInterface
{

    public function userInfo($id) {
        $params = [
            'user_id' => $id,
            'v' => '5.52'
        ];

        $http = http_build_query($params);
        $url = 'https://api.vk.com/method/users.get?' . $http;
        $result = json_decode(file_get_contents($url), true);

        return $result['response'][0];
    }
}