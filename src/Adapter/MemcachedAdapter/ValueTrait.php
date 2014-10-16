<?php namespace AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;

use AdammBalogh\KeyValueStore\Adapter\Util;
use AdammBalogh\KeyValueStore\Exception\KeyNotFoundException;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
trait ValueTrait
{
    use ClientTrait;

    /**
     * Gets the value of a key.
     *
     * @param string $key
     *
     * @return mixed The value of the key.
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function get($key)
    {
        $getResult = $this->getValue($key);
        $unserialized = @unserialize($getResult);

        if (Util::hasInternalExpireTime($unserialized)) {
            $getResult = $unserialized['v'];
        }

        return $getResult;
    }

    /**
     * Sets the value of a key.
     *
     * @param string $key
     * @param mixed $value Can be any of serializable data type.
     *
     * @return bool True if the set was successful, false if it was unsuccessful.
     *
     * @throws \Exception
     */
    public function set($key, $value)
    {
        $setResult = $this->getClient()->set($key, $value);
        if ($setResult === false) {
            throw new \Exception($this->getClient()->getResultMessage(), $this->getClient()->getResultCode());
        }
        return $setResult;
    }

    /**
     * @param string $key
     *
     * @return string
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    protected function getValue($key)
    {
        $getResult = $this->getClient()->get($key);

        if ($this->getClient()->getResultCode() === \Memcached::RES_NOTFOUND) {
            throw new KeyNotFoundException();
        } elseif ($getResult === false) {
            throw new \Exception($this->getClient()->getResultMessage(), $this->getClient()->getResultCode());
        }

        return $getResult;
    }
}
