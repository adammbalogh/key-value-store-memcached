<?php namespace AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;

use AdammBalogh\KeyValueStore\Adapter\Helper;
use AdammBalogh\KeyValueStore\Exception\KeyNotFoundException;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
trait KeyTrait
{
    use ClientTrait;

    /**
     * @param string $key
     *
     * @return bool True if the deletion was successful, false if the deletion was unsuccessful.
     *
     * @throws \Exception
     */
    public function delete($key)
    {
        return $this->getClient()->delete($key);
    }

    /**
     * @param string $key
     * @param int $seconds
     *
     * @return bool True if the timeout was set, false if the timeout could not be set.
     *
     * @throws \Exception
     */
    public function expire($key, $seconds)
    {
        try {
            $value = $this->get($key);
        } catch (KeyNotFoundException $e) {
            return false;
        }

        return $this->getClient()->replace(
            $key,
            Helper::getDataWithExpire($value, $seconds, time()),
            $seconds
        );
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getKeys()
    {
        return $this->getClient()->getAllKeys();
    }

    /**
     * Returns the remaining time to live of a key that has a timeout.
     *
     * @param string $key
     *
     * @return int Ttl in seconds
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function getTtl($key)
    {
        $getResult = $this->getValue($key);
        $unserialized = @unserialize($getResult);

        if (!Helper::hasInternalExpireTime($unserialized)) {
            throw new \Exception('Cannot retrieve ttl');
        }

        return $unserialized['ts'] + $unserialized['s'] - time();
    }

    /**
     * @param string $key
     *
     * @return bool True if the key does exist, false if the key does not exist.
     *
     * @throws \Exception
     */
    public function has($key)
    {
        try {
            $this->get($key);
        } catch (KeyNotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Remove the existing timeout on key, turning the key from volatile (a key with an expire set)
     * to persistent (a key that will never expire as no timeout is associated).
     *
     * @param string $key
     *
     * @return bool True if the persist was success, false if the persis was unsuccessful.
     *
     * @throws \Exception
     */
    public function persist($key)
    {
        $getResult = $this->getValue($key);
        $unserialized = @unserialize($getResult);

        if (!Helper::hasInternalExpireTime($unserialized)) {
            throw new \Exception("{$key} has no associated timeout");
        }

        return $this->getClient()->replace($key, $unserialized['v'], 0);
    }
}