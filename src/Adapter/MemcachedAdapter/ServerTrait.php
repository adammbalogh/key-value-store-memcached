<?php namespace AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter;

trait ServerTrait
{
    use ClientTrait;

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function flush()
    {
        if (!$this->getClient()->flush()) {
            throw new \Exception($this->getClient()->getResultMessage(), $this->getClient()->getResultCode());
        }
    }
}
