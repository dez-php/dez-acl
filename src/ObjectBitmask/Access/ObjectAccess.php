<?php

namespace Dez\ACL\ObjectBitmask\Access;

use Dez\ACL\Common\Collection\ObjectCollection;
use Dez\ACL\Common\Exception\AccessDeniedException;
use Dez\ACL\ObjectBitmask\Domain\ObjectIdentity;
use Serializable;

/**
 * Class ObjectAccess
 * @package Dez\ACL\ObjectBitmask\Access
 */
class ObjectAccess implements ObjectAccessInterface, Serializable
{

    /**
     * @var ObjectCollection|null
     */
    protected $accesses = null;

    /**
     * ObjectAccess constructor.
     */
    public function __construct()
    {
        $this->accesses = new ObjectCollection();
    }

    /**
     * @param ObjectIdentity $objectIdentity
     * @param int $mask
     * @return $this
     */
    public function grant(ObjectIdentity $objectIdentity, $mask = 0)
    {
        $this->accesses->set($objectIdentity->getIdentifier(), (new Mask())->set($mask));

        return $this;
    }

    /**
     * @param ObjectIdentity $objectIdentity
     * @param int $mask
     * @return bool
     * @throws AccessDeniedException
     */
    public function allowed(ObjectIdentity $objectIdentity, $mask = 0)
    {
        if (!$this->accesses->has($objectIdentity->getIdentifier())) {
            throw new AccessDeniedException('Permissions do not exists for security object ":identity"', [
                'identity' => $objectIdentity->getIdentifier(),
            ]);
        }

        if (!$this->accesses->get($objectIdentity->getIdentifier())->has($mask)) {
            throw new AccessDeniedException('Access denied for security object ":identity"', [
                'identity' => $objectIdentity->getIdentifier(),
            ]);
        }

        return true;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->accesses);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $accesses = unserialize($serialized);
        $this->accesses = new ObjectCollection();

        foreach ($accesses as $identity => $mask) {
            $this->accesses->set($identity, $mask);
        }
    }
}