<?php namespace AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;

use AdammBalogh\KeyValueStore\AbstractKvsMemcachedTestCase;
use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;
use AdammBalogh\KeyValueStore\KeyValueStore;

class ServerTraitTest extends AbstractKvsMemcachedTestCase
{
    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testFlush(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('flush')->andReturn(true);

        $this->assertNull($kvs->flush());
    }

    /**
     * @expectedException \Exception
     *
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testFlushError(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('flush')->andReturn(false);

        $kvs->flush();
    }
}
