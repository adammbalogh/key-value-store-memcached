<?php namespace AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;

use AdammBalogh\KeyValueStore\AbstractKvsMemcachedTestCase;
use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;
use AdammBalogh\KeyValueStore\Adapter\Util;
use AdammBalogh\KeyValueStore\KeyValueStore;

class StringTraitTest extends AbstractKvsMemcachedTestCase
{
    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testAppend(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('value-e');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);
        $dummyMemchd->shouldReceive('set')->andReturn(true);

        $this->assertEquals(15, $kvs->append('key-e', 'appended'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testAppendSerialized(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn(Util::getDataWithExpire('value-e', 5, time()));
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);
        $dummyMemchd->shouldReceive('set')->andReturn(true);

        $this->assertEquals(15, $kvs->append('key-e', 'appended'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testDecrement(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('4');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);
        $dummyMemchd->shouldReceive('set')->andReturn(true);

        $this->assertEquals(3, $kvs->decrement('key-e'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testDecrementBy(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('4');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);
        $dummyMemchd->shouldReceive('set')->andReturn(true);

        $this->assertEquals(1, $kvs->decrementBy('key-e', 3));
    }

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
    public function testGetValueLength(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('value-e');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);

        $this->assertEquals(7, $kvs->getValueLength('key-e'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testIncrement(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('4');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);
        $dummyMemchd->shouldReceive('set')->andReturn(true);

        $this->assertEquals(5, $kvs->increment('key-e'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testIncrementBy(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('4');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);
        $dummyMemchd->shouldReceive('set')->andReturn(true);

        $this->assertEquals(9, $kvs->incrementBy('key-e', 5));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testIncrementBySerialized(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn(Util::getDataWithExpire('4', 5, time()));
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);
        $dummyMemchd->shouldReceive('set')->andReturn(true);

        $this->assertEquals(9, $kvs->incrementBy('key-e', 5));
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
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testSetIfNotExists(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn(false);
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_NOTFOUND);
        $dummyMemchd->shouldReceive('set')->with('key-e', 'value-e')->andReturn(true);

        $this->assertTrue($kvs->setIfNotExists('key-e', 'value-e'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param MemcachedAdapter $dummyMemchdAdapter
     * @param \Memcached $dummyMemchd
     */
    public function testSetIfNotExistsWithExistingKey(KeyValueStore $kvs, MemcachedAdapter $dummyMemchdAdapter, \Memcached $dummyMemchd)
    {
        $dummyMemchd->shouldReceive('get')->with('key-e')->andReturn('value-e');
        $dummyMemchd->shouldReceive('getResultCode')->andReturn(\Memcached::RES_SUCCESS);

        $this->assertFalse($kvs->setIfNotExists('key-e', 'value-e'));
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
