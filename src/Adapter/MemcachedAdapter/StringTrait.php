<?php namespace AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;

use AdammBalogh\KeyValueStore\Adapter\Helper;
use AdammBalogh\KeyValueStore\Exception\KeyNotFoundException;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
trait StringTrait
{
    use ClientTrait;

    /**
     * @param string $key
     * @param string $value
     *
     * @return int The length of the string after the append operation.
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function append($key, $value)
    {
        $getResult = $this->getValue($key);
        $unserialized = @unserialize($getResult);

        if (Helper::hasInternalExpireTime($unserialized)) {
            $this->set(
                $key,
                Helper::getDataWithExpire(
                    $unserialized['v'] . $value,
                    $unserialized['s'],
                    $unserialized['ts']
                )
            );

            return strlen($unserialized['v'] . $value);
        }

        $this->set($key, $getResult . $value);

        return strlen($getResult . $value);
    }

    /**
     * @param string $key
     *
     * @return int The value of key after the decrement
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function decrement($key)
    {
        return $this->decrementBy($key, 1);
    }

    /**
     * @param string $key
     * @param int $decrement
     *
     * @return int The value of key after the decrement
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function decrementBy($key, $decrement)
    {
        return $this->incrementBy($key, -$decrement);
    }

    /**
     * @param string $key
     *
     * @return string The value of the key
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function get($key)
    {
        $getResult = $this->getValue($key);
        $unserialized = @unserialize($getResult);

        if (Helper::hasInternalExpireTime($unserialized)) {
            $getResult = $unserialized['v'];
        }

        return $getResult;
    }

    /**
     * @param string $key
     *
     * @return int
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function getValueLength($key)
    {
        return strlen($this->get($key));
    }

    /**
     * @param string $key
     *
     * @return int The value of key after the increment
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function increment($key)
    {
        return $this->incrementBy($key, 1);
    }

    /**
     * @param string $key
     * @param int $increment
     *
     * @return int The value of key after the increment
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function incrementBy($key, $increment)
    {
        $getResult = $this->getValue($key);
        $unserialized = @unserialize($getResult);

        if (Helper::hasInternalExpireTime($unserialized)) {

            Helper::checkInteger($unserialized['v']);
            $this->set(
                $key,
                Helper::getDataWithExpire(
                    (int)$unserialized['v'] + $increment,
                    $unserialized['s'],
                    $unserialized['ts']
                )
            );

            return (int)$unserialized['v'] + $increment;
        }

        Helper::checkInteger($getResult);
        $this->set($key, (int)$getResult + $increment);

        return (int)$getResult + $increment;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool True if the set was successful, false if it was unsuccessful
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
     * @param string $value
     *
     * @return bool True if the set was successful, false if it was unsuccessful
     *
     * @throws \Exception
     */
    public function setIfNotExists($key, $value)
    {
        if ($this->has($key)) {
            return false;
        }

        return $this->set($key, $value);
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
