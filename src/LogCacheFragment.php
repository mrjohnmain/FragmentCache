<?php

namespace MrJohnMain\FragmentCache;

class LogCacheFragment extends \Eloquent
{
    /**
     * The cache instance.
     *
     * @var Cach
     */
    protected $table = 'log_cache_fragments';

    protected $fillable = ['user_id', 'key'];
}
