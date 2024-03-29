<?php

namespace MrJohnMain\FragmentCache;

use Illuminate\Contracts\Cache\Repository;

class Cache
{
    /**
     * The cache repository.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Create a new class instance.
     *
     * @param Repository $cache
     */
    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Put to the cache.
     *
     * @param mixed  $key
     * @param string $fragment
     */
    public function put($key, $fragment)
    {
        $this->cache->forever($key, $fragment);

        return $fragment;
    }

    /**
     * Check if the given key exists in the cache.
     *
     * @param mixed $key
     */
    public function has($key)
    {
        return $this->cache->has($key);
    }

    /**
     * Get from the cache
     *
     * @param mixed $key
     */
    public function get($key)
    {
        return $this->cache->get($key);
    }

    /**
     * Clear the key from the cache
     *
     * @param mixed $key
     */
    public function forget($key)
    {
        return $this->cache->forget($key);
    }
}

