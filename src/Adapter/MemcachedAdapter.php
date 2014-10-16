<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter\ClientTrait;
use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter\KeyTrait;
use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter\ValueTrait;
use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter\ServerTrait;

class MemcachedAdapter extends AbstractAdapter
{
    use ClientTrait, KeyTrait, ValueTrait, ServerTrait {
        ClientTrait::getClient insteadof KeyTrait;
        ClientTrait::getClient insteadof ValueTrait;
        ClientTrait::getClient insteadof ServerTrait;
    }

    /**
     * @var \Memcached
     */
    protected $client;

    /**
     * @param \Memcached $client
     */
    public function __construct(\Memcached $client)
    {
        $this->client = $client;
    }
}
