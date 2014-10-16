<?php namespace AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;

use AdammBalogh\KeyValueStore\AbstractKvsMemcachedTestCase;
use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;
use AdammBalogh\KeyValueStore\Adapter\Util;
use AdammBalogh\KeyValueStore\KeyValueStore;

class ValueTraitTest extends AbstractKvsMemcachedTestCase
{
    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testGet(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('value-e');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);

        $this->assertEquals('value-e', $kvs->get('key-e'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testGetSerialized(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn(Util::getDataWithExpire('value-e', 5, time()));
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);

        $this->assertEquals('value-e', $kvs->get('key-e'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testSet(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('set')->with('key-e', 'value-e')->andReturn(true);

        $this->assertTrue($kvs->set('key-e', 'value-e'));
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
    public function testSetError(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('set')->with('key-e', 'value-e')->andReturn(false);

        $kvs->set('key-e', 'value-e');
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
    public function testGetValueError(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn(false);
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);

        $kvs->get('key-e');
    }
}
