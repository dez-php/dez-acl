<?php

namespace Dez\ACL\ObjectBitmask\Domain;

/**
 * Interface ObjectIdentityInterface
 * @package Dez\ACL\ObjectBitmask\Domain
 */
interface ObjectIdentityInterface {

    /**
     * @param ObjectIdentityInterface $objectIdentity
     * @return boolean
     */
    public function equals(ObjectIdentityInterface $objectIdentity);

    /**
     * @return mixed
     */
    public function getIdentifier();

}