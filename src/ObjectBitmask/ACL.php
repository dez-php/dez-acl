<?php

namespace Dez\ACL\ObjectBitmask;

use Dez\ACL\Common\Collection\ObjectCollection;
use Dez\ACL\ObjectBitmask\Access\ObjectAccess;
use Dez\ACL\ObjectBitmask\Domain\ObjectIdentity;
use Dez\Config\Config;
use Serializable;

/**
 * Class ACL
 * @package Dez\ACL\ObjectBitmask
 */
class ACL implements Serializable
{

    /**
     * @var ObjectCollection|ObjectAccess[]
     */
    protected $identities = null;

    /**
     * ACL constructor.
     */
    public function __construct()
    {
        $this->identities = new ObjectCollection();
    }

    public function registerObject($object)
    {
        if(!($object instanceof ObjectIdentity)) {
            $object = ObjectIdentity::createFromObject($object);
        }

        $access = new ObjectAccess();
        $this->identities->set($object->getIdentifier(), $access);

        return $access;
    }

    public function serialize()
    {
        return serialize($this->identities);
    }

    public function unserialize($serialized)
    {
        /** @var ObjectCollection|ObjectAccess[] */
        $identities = $this->unserialize($serialized);

        foreach ($identities as $identity => $access) {
            $this->identities->set($identity, $access);
        }
    }


}