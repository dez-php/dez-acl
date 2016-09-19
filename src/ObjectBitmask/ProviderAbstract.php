<?php

namespace Dez\ACL\ObjectBitmask;

use Dez\ACL\Common\Collection\ObjectCollection;
use Dez\ACL\ObjectBitmask\Access\ObjectAccess;
use Dez\ACL\ObjectBitmask\Domain\ObjectIdentity;
use Serializable;

/**
 * Class ProviderAbstract
 * @package Dez\ACL\ObjectBitmask
 */
class ProviderAbstract implements Serializable
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

    /**
     * @param ObjectIdentity $objectIdentity
     * @return ObjectAccess|null
     */
    public function getIdentity(ObjectIdentity $objectIdentity)
    {
        return $this->identities->get($objectIdentity->getIdentifier());
    }

    public function grantObject(ObjectIdentity $objectIdentity, ObjectIdentity $secureObject, $mask = 0)
    {
        $this->registerObject($objectIdentity)->grant($secureObject, $mask);

        return $this;
    }

    public function registerObject($object)
    {
        if (!($object instanceof ObjectIdentity)) {
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
        $identities = unserialize($serialized);
        $this->identities = new ObjectCollection();

        foreach ($identities as $identity => $access) {
            $this->identities->set($identity, $access);
        }
    }


}