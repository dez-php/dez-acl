<?php

namespace Dez\ACL\ObjectBitmask\Domain;

use Dez\ACL\Common\Collection\ObjectCollection;
use Dez\ACL\ObjectBitmask\Mask\Mask;
use JsonSerializable;

/**
 * Class ObjectPermissions
 * @package Dez\ACL\ObjectBitmask\Mask
 */
class ObjectPermissions implements ObjectPermissionsInterface, JsonSerializable
{

    /**
     * @var ObjectCollection|Mask[]
     */
    protected $permissions = null;

    /**
     * ObjectAccess constructor.
     */
    public function __construct()
    {
        $this->permissions = new ObjectCollection();
    }

    /**
     * @param ObjectIdentity $objectIdentity
     * @param int $mask
     * @return $this
     */
    public function grant(ObjectIdentity $objectIdentity, $mask = 0)
    {
        $this->permissions->set($objectIdentity->getIdentifier(), new Mask($mask));

        return $this;
    }

    /**
     * @param ObjectIdentity $objectIdentity
     * @param int $mask
     * @return bool
     */
    public function allowed(ObjectIdentity $objectIdentity, $mask = 0)
    {
        if ($this->permissions->has($objectIdentity->getIdentifier())) {
            return $this->permissions[$objectIdentity->getIdentifier()]->has($mask);
        }

        return false;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return $this->permissions;
    }


}