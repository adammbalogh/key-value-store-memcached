<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\AbstractKvsMemcachedTestCase;
use AdammBalogh\KeyValueStore\KeyValueStore;

class MemcachedAdapterTest extends AbstractKvsMemcachedTestCase
{
    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testInstantiation(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        new MemcachedAdapter($dummyMemchd);
    }
}
