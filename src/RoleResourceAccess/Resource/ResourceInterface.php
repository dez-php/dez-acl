<?php

namespace Dez\ACL\RoleResourceAccess\Resource;

use Dez\ACL\RoleResourceAccess\Access\AccessInterface;

/**
 * Interface ResourceInterface
 * @package Dez\ACL\RoleResourceAccess\Resource
 */
interface ResourceInterface {

    /**
     * @return mixed
     */
    public function getResourceName();


    /**
     * @param AccessInterface $access
     * @return $this
     */
    public function addAccess(AccessInterface $access);

    /**
     * @param string $name
     * @return AccessInterface
     */
    public function getAccess($name);

    /**
     * @param $name
     * @return boolean
     */
    public function hasAccess($name);

}