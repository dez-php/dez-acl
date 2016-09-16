<?php

namespace Dez\ACL\Common\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Serializable;

/**
 * Class AbstractCollection
 * @package Dez\ACL\Common\Collection
 */
abstract class AbstractCollection implements ArrayAccess, IteratorAggregate, Countable, JsonSerializable, Serializable, CollectionInterface
{

    /**
     * @var array
     */
    protected $data = [];

    /**
     * AbstractCollection constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->batch($data);
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->data[$key] : $default;
    }

    /**
     * @param array $keys
     * @return array
     */
    public function all(array $keys = [])
    {
        return empty($keys) ? $this->data : array_intersect_key($this->data, array_flip($keys));
    }

    /**
     * @param array $data
     * @return $this
     */
    public function batch(array $data)
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $data
     * @return $this
     */
    public function set($key, $data)
    {
        $this->data[$key] = $data;

        return $this;
    }

    /**
     * @param $key
     * @param $data
     * @return $this
     */
    public function push($key, $data)
    {
        if (is_array($this->get($key))) {
            $this->data[$key][] = $data;
        } else {
            $this->set($key, [$data]);
        }

        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function remove($key)
    {
        unset($this->data[$key]);

        return $this;
    }

    /**
     * @return array
     */
    public function keys()
    {
        return array_keys($this->data);
    }

    /**
     * @param \Closure $closure
     * @param array $context
     * @return CollectionInterface|static
     */
    public function map(\Closure $closure, array $context = [])
    {
        $collection = new static();

        foreach ($this as $key => $data) {
            $collection->push($key, $closure($data, $context));
        }

        return $collection;
    }

    /**
     * @param \Closure $closure
     * @return $this
     */
    public function each(\Closure $closure)
    {
        foreach ($this as $key => $data) {
            $closure($key, $data);
        }

        return $this;
    }

    /**
     * @param \Closure $closure
     * @return $this
     */
    public function sort(\Closure $closure)
    {
        usort($this->data, $callback);

        return $this;
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return $this->count() > 0;
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->data = [];

        return $this;
    }

    /**
     * @return \stdClass
     */
    public function toObject()
    {
        $objectData = new \stdClass();

        foreach ($this as $key => $data) {
            $objectData->{$key} = ($data instanceof CollectionInterface)
                ? $data->toObject()
                : $data;
        }

        return $objectData;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $arrayData = [];

        foreach ($this as $key => $data) {
            $arrayData[$key] = ($data instanceof CollectionInterface)
                ? $data->toArray()
                : $data;
        }

        return $arrayData;
    }

    /**
     * @return string
     */
    public function toJSON()
    {
        return json_encode($this);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->get($offset, null);
    }

    /**
     * @param mixed $offset
     * @param mixed $data
     */
    public function offsetSet($offset, $data)
    {
        if(null === $offset) {
            $this->data[] = $data;
        } else {
            $this->data[$offset] = $data;
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return $this->data;
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->batch(unserialize($serialized));
    }


}