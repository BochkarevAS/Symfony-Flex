<?php

namespace App\Service\API\VK;

class VkFriendService implements VkRenderInterface
{
    private $version = '5.52';

    public function render($id)
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

        return $result['response'];
    }
}