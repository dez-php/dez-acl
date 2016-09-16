<?php

namespace Dez\ACL\ObjectBitmask\Access;

/**
 * Class AbstractMask
 * @package Dez\ACL\ObjectBitmask\Access
 */
abstract class AbstractMask implements MaskInterface {

    /**
     * @var int
     */
    protected $mask = 0;

    /**
     * @param int $mask
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function set($mask)
    {
        if(! is_int($mask)) {
            throw new \InvalidArgumentException("Mask is invalid. Should be an integer");
        }

        $this->mask = $mask;

        return $this;
    }

    /**
     * @param $mask
     * @return $this
     */
    public function add($mask)
    {
        $this->mask |= $this->resolve($mask);

        return $this;
    }

    /**
     * @return int
     */
    public function get()
    {
        return $this->mask;
    }

    /**
     * @param int $mask
     * @return MaskInterface
     */
    public function remove($mask)
    {
        $this->mask &= ~ $this->resolve($mask);

        return $this;
    }

    /**
     * @return MaskInterface
     */
    public function reset()
    {
        $this->mask = 0;

        return $this;
    }

    /**
     * @param int|string $mask
     * @throws \InvalidArgumentException
     * @return int
     */
    public function resolve($mask)
    {
        if(is_string($mask)) {
            if(! defined($name = sprintf(static::class . '::MASK_%s', strtoupper($mask)))) {
                throw new \InvalidArgumentException("Constant do not exists $name");
            }

            return constant($name);
        }

        if(! is_int($mask)) {
            throw new \InvalidArgumentException("Mask is invalid. Should be an integer");
        }

        return $mask;
    }

    /**
     * @param $mask
     * @return bool
     */
    public function has($mask)
    {
        return (boolean) ($this->mask & $this->resolve($mask));
    }


}