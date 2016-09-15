<?php

namespace Dez\Acl\Resource;

/**
 * Interface ObjectIdentityInterface
 * @package Dez\Acl\Resource
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