<?php

namespace Dez\ACL\RoleResourceAccess\Access;

use Serializable;

/**
 * Class Mask
 * @package Dez\ACL\RoleResourceAccess\Mask
 */
class Access implements AccessInterface, Serializable {

    /**
     * @var string
     */
    protected $name;

    /**
     * Common constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAccessName()
    {
        return $this->name;
    }


    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize($this->name);
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
        $this->name = unserialize($serialized);
    }
}