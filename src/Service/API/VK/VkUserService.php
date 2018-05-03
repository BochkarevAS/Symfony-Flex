<?php

namespace App\Service\API\VK;

class VkUserService implements VkInterface
{
    private $version = '5.52';

    public function getUser($id) {
        $params = [
            'user_id' => $id,
            'v' => $this->version
        ];

        $url = 'https://api.vk.com/method/users.get?' . http_build_query($params);
        $result = json_decode(file_get_contents($url), true);

        return $result['response'][0];
    }
}