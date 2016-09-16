<?php

namespace Dez\ACL\RoleResourceAccess\Role;

/**
 * Class Role
 * @package Dez\ACL\RoleResourceAccess\Role
 */
class Role implements RoleInterface {

    /**
     * @var string
     */
    protected $name = null;

    /**
     * Role constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getRoleName()
    {
        return $this->name;
    }


}