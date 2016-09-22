<?php

namespace Dez\ACL\RoleResourceAccess\Resource;

use Dez\ACL\Common\Collection\ObjectCollection;
use Dez\ACL\RoleResourceAccess\Access\AccessInterface;
use Serializable;

class Resource implements ResourceInterface, Serializable {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ObjectCollection
     */
    protected $accesses = null;

    /**
     * Resource constructor.
     * @param string $name
     * @param array $permissions
     */
    public function __construct($name, array $permissions = [])
    {
        $this->accesses = new ObjectCollection();
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getResourceName()
    {
        return $this->name;
    }

    /**
     * @param AccessInterface $access
     * @return $this
     */
    public function addAccess(AccessInterface $access)
    {
        $this->accesses->set($access->getAccessName(), $access);

        return $this;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getAccess($name)
    {
        return $this->accesses->get($name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasAccess($name)
    {
        return $this->accesses->has($name);
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([$this->getResourceName(), $this->accesses]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list($this->name, $this->accesses) = unserialize($serialized);
    }
}