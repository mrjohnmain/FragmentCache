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

    protected $log;

    protected $start_time;

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

        $this->log = LogCacheFragment::create(['user_id' => \Auth::id(), 'key' => $key]);

        $this->start_time = microtime(true);

        if($force) {
            $this->cache->forget($key);
            $this->has_cache = false;
            $this->log->status = 2;
        }
        elseif($this->cache->has($key)) {
            $this->has_cache =  true;
            $this->log->status = 1;
        }
        else {
            $this->has_cache = false;
            $this->log->status = 0;
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
            $data = $this->cache->get($this->key);
        }
        else {
            $data = $this->cache->put(
                $this->key, ob_get_clean()
            );
        }

        $this->log->timing = (microtime(true) - $this->start_time) * 1000;
        $this->log->save();

        return $data;
    }
}
