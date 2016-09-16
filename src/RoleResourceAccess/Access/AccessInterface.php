<?php

namespace Dez\ACL\RoleResourceAccess\Access;

/**
 * Interface PermissionInterface
 * @package Dez\ACL\RoleResourceAccess\Access
 */
interface AccessInterface {

    /**
     * @return string
     */
    public function getAccessName();

}