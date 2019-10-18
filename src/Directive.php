<?php

namespace MrJohnMain\FragmentCache;

use Exception;

class Directive
{
    /**
     * The cache instance.
     *
     * @var Cach
     */
    protected $cache;

    /**
     * Active cache key
     *
     * @param string $key
     */
    protected $key;

    /**
     * Create a new instance.
     *
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Handle the @cache setup.
     *
     * @param string $key_data
     */
    public function setUp($key_data)
    {
        if($data = json_decode($key_data)) {
            $key = $data->key;
            $force = $data->force;
        }
        else {
            $key = $key_data;
            $force = false;
        }

        ob_start();

        $this->key = $key;

        if($force) {
            $this->cache->forget($key);
            return false;
        }

        return $this->cache->has($key);
    }

    /**
     * Handle the @endcache teardown.
     */
    public function tearDown()
    {
        return $this->cache->put(
            $this->key, ob_get_clean()
        );
    }
}
