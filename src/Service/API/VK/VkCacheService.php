<?php

namespace App\Service\API\VK;

use Psr\SimpleCache\CacheInterface;

class VkCacheService implements VkRenderInterface
{
    private $pool;
    private $cache;

    public function __construct(VkRenderInterface $pool, CacheInterface $cache)
    {
        $this->pool = $pool;
        $this->cache = $cache;
    }

    public function render($id)
    {
        $data = $this->cache->get("key");

        if (!$data) {
            $data = $this->pool->render($id);
            $this->cache->set("key", $data, 300);
        }

        return $data;
    }
}