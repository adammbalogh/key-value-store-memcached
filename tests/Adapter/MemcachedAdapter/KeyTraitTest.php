<?php namespace AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;

use AdammBalogh\KeyValueStore\AbstractKvsMemcachedTestCase;
use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;
use AdammBalogh\KeyValueStore\Adapter\Util;
use AdammBalogh\KeyValueStore\KeyValueStore;

class KeyTraitTest extends AbstractKvsMemcachedTestCase
{
    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testDelete(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('delete')->with('key-e')->andReturn(true);
        $dummyMemchd->shouldReceive('delete')->with('key-ne')->andReturn(false);

        $this->assertTrue($kvs->delete('key-e'));
        $this->assertFalse($kvs->delete('key-ne'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testExpire(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('value-e');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);
        $dummyMemchd->shouldReceive('replace')->andReturn(true);

        $this->assertTrue($kvs->expire('key-e', 1));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testExpireKeyNotFound(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-ne')->andReturn('value-ne');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_NOTFOUND);

        $this->assertFalse($kvs->expire('key-ne', 1));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testGetTtl(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn(Util::getDataWithExpire('value-e', 5, time()));
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);

        $this->assertLessThanOrEqual(5, $kvs->getTtl('key-e'));
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
    public function testGetTtlNonSerialized(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('value-e');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);

        $kvs->getTtl('key-e');
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testHas(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('value-e');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);

        $this->assertTrue($kvs->has('key-e'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testHasKeyNotFound(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-ne')->andReturn('value-ne');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_NOTFOUND);

        $this->assertFalse($kvs->has('key-ne'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testPersist(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn(Util::getDataWithExpire('value-e', 5, time()));
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);
        $dummyMemchd->shouldReceive('replace')->andReturn(true);

        $this->assertTrue($kvs->persist('key-e'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testPersistNonSerialized(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('value-e');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);

        $this->assertFalse($kvs->persist('key-e'));
    }
}
