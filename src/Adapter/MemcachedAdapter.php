<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter\ClientTrait;
use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter\KeyTrait;
use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter\ServerTrait;
use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter\StringTrait;

class MemcachedAdapter extends AbstractAdapter
{
    use ClientTrait, KeyTrait, StringTrait, ServerTrait {
        ClientTrait::getClient insteadof KeyTrait;
        ClientTrait::getClient insteadof StringTrait;
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
