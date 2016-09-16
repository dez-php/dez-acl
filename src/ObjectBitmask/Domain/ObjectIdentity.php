<?php

namespace Dez\ACL\ObjectBitmask\Domain;

use Dez\ACL\Common\Exception\BadArgumentException;

/**
 * Class ObjectIdentity
 * @package Dez\ACL\ObjectBitmask\Domain
 */
final class ObjectIdentity implements ObjectIdentityInterface
{

    /**
     * @var string
     */
    private $identifier = null;

    /**
     * ObjectIdentity constructor.
     * @param string $identifier
     */
    public function __construct($identifier = null)
    {
        $this->identifier = $identifier;
    }

    /**
     * @param ObjectIdentityInterface $objectIdentity
     * @return bool
     */
    public function equals(ObjectIdentityInterface $objectIdentity)
    {
        return $this->getIdentifier() === $objectIdentity->getIdentifier();
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param $object
     * @return static
     * @throws BadArgumentException
     */
    public static function createFromObject($object)
    {
        if(! is_object($object)) {
            throw new BadArgumentException('Method ":method" takes only the object ":type" given', [
                'method' => __METHOD__,
                'type' => gettype($object)
            ]);
        }

        if($object instanceof ObjectIdentityInterface) {
            return new static($object->getIdentifier());
        }

        $identifier = get_class($object);
        if(method_exists($object, 'getId')) {
            $identifier = "{$identifier}::{$object->getId()}";
        }

        return new static($identifier);
    }

}