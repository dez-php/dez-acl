<?php

namespace Dez\ACL\ObjectBitmask\Access;

use Dez\ACL\Common\Collection\ObjectCollection;
use Dez\ACL\ObjectBitmask\Domain\ObjectIdentity;
use Serializable;

class ObjectAccess implements ObjectAccessInterface, Serializable {

    protected $accesses = null;

    public function __construct()
    {
        $this->accesses = new ObjectCollection();
    }

    public function grant(ObjectIdentity $objectIdentity, $mask = 0)
    {
        $this->accesses->set($objectIdentity->getIdentifier(), (new Mask())->set($mask));

        return $this;
    }

    public function serialize()
    {
       return serialize($this->accesses);
    }

    public function unserialize($serialized)
    {
        $accesses = unserialize($serialized);

        foreach ($accesses as $identity => $mask) {
            $this->accesses->set($identity, (new Mask())->set($mask));
        }
    }
}