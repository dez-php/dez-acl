<?php

namespace Dez\Acl\Resource;

use Dez\Acl\Permission\PermissionInterface;
use Dez\Acl\Permission\Predicate;

/**
 * Interface ResourceInterface
 * @package Dez\Acl\Resource
 */
interface ResourceInterface extends ObjectIdentityInterface {

    /**
     * @return mixed
     */
    public function getResourceName();


    /**
     * @param PermissionInterface $permission
     * @return $this
     */
    public function addPermission(PermissionInterface $permission);

    /**
     * @param string $name
     * @return PermissionInterface
     */
    public function getPermission($name);

    /**
     * @param $name
     * @return boolean
     */
    public function hasPermission($name);

}