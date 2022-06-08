<?php

namespace Ll\llcms\Models;


use Dcat\Admin\Admin;
use Illuminate\Support\Facades\Cache;

trait CategoryCache
{
    protected $cacheKey = 'Category-%d-%s';

    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @param  \Closure  $builder
     * @return mixed
     */
    protected function remember(\Closure $builder)
    {
        if (! $this->enableCache()) {
            return $builder();
        }

        return $this->getStore()->remember($this->getCacheKey(), null, $builder);
    }

    /**
     * @return bool|void
     */
    public function flushCache()
    {
        if (! $this->enableCache()) {
            return;
        }

        return $this->getStore()->delete($this->getCacheKey());
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return sprintf($this->cacheKey, (int) static::withPermission(), Admin::app()->getName());
    }

    /**
     * @return bool
     */
    public function enableCache()
    {
        return true;
    }

    /**
     * Get cache store.
     *
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function getStore()
    {
        return Cache::store(config('cache.default', 'file'));
    }
}
