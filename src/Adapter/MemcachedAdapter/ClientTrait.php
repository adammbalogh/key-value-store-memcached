<?php namespace AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;

trait ClientTrait
{
    /**
     * @return \Memcached
     */
    public function getClient()
    {
        return $this->client;
    }
}
