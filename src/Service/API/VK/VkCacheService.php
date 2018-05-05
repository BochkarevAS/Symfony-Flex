<?php

namespace App\Service\API\VK;

use Psr\Cache\CacheItemPoolInterface;

class VkCacheService
{
    private $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    public function cacheFollowers($followers)
    {
        $item = $this->cache->getItem('followers');

        if (!$item->isHit()) {
            $item->set($followers);
            $item->expiresAfter(1000);
            $this->cache->save($item);
        }

        return $item->get();
    }

    public function cacheFriends($friends)
    {
        $item = $this->cache->getItem('friends');

        if (!$item->isHit()) {
            $item->set($friends);
            $item->expiresAfter(1000);
            $this->cache->save($item);
        }

        return $item->get();
    }
}