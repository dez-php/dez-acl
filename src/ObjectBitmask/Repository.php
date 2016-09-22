<?php

namespace Dez\ACL\ObjectBitmask;

use Dez\ACL\Common\Collection\ObjectCollection;
use Dez\ACL\Common\Exception\BadCallMethodException;
use Dez\ACL\ObjectBitmask\Domain\ObjectIdentity;
use Dez\ACL\ObjectBitmask\Domain\ObjectPermissions;
use Dez\ACL\ObjectBitmask\Mask\MaskInterface;

/**
 * Class Repository
 * @package Dez\ACL\ObjectBitmask
 */
class Repository extends ObjectCollection {

    /**
     * @param object $objectIdentity
     * @param object $secureObject
     * @param int $mask
     * @return $this
     */
    public function grant($objectIdentity, $secureObject, $mask = null)
    {
        $objectIdentity = ObjectIdentity::createFromObject($objectIdentity);
        $secureObject = ObjectIdentity::createFromObject($secureObject);

        if(! $this->has($objectIdentity->getIdentifier())) {
            $this[$objectIdentity->getIdentifier()] = new ObjectPermissions();
        }

        if($mask instanceof MaskInterface) {
            $mask = $mask->get();
        }

        $this[$objectIdentity->getIdentifier()]->grant($secureObject, $mask);

        return $this;
    }

    /**
     * @param $key
     * @param $data
     * @return ObjectCollection
     */
    public function set($key, $data)
    {
        return parent::set($key, $data);
    }


    /**
     * @param $key
     * @param $data
     * @return $this|void
     * @throws BadCallMethodException
     */
    public function push($key, $data)
    {
        throw new BadCallMethodException('Not allowed call method ":method" for collection ":collection"', [
            'method' => __FUNCTION__,
            'collection' => __CLASS__,
        ]);
    }


}