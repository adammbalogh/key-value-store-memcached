<?php namespace AdammBalogh\KeyValueStore;

use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;

abstract class AbstractKvsMemcachedTestCase extends \PHPUnit_Framework_TestCase
{
    public function getDummyMemcached()
    {
        return \Mockery::mock('Memcached');
    }

    public function getDummyMemcachedAdapter(\Memcached $memcached)
    {
        return new MemcachedAdapter($memcached);
    }

    public function kvsProvider()
    {
        $dummyMemchd = $this->getDummyMemcached();
        $dummyMemchdAdapter = $this->getDummyMemcachedAdapter($dummyMemchd);

        return [
            [
                new KeyValueStore($dummyMemchdAdapter),
                $dummyMemchdAdapter,
                $dummyMemchd
            ]
        ];
    }
}
