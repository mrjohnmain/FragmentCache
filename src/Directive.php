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
     * Has cache data
     *
     * @param string $key
     */
    protected $has_cache = false;

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

        $this->key = $key;

        if($force) {
            $this->cache->forget($key);
            $this->has_cache = false;
        }
        else {
            $this->has_cache = $this->cache->has($key);
        }

        if($this->has_cache) {
            //Nothing to buffer if we already have it
            return true;
        }

        ob_start();
        return false;
    }

    /**
     * Handle the @endcache teardown.
     */
    public function tearDown()
    {
        if($this->has_cache) {
            //Return it directly
            return $this->cache->get($this->key);
        }

        return $this->cache->put(
            $this->key, ob_get_clean()
        );
    }
}
